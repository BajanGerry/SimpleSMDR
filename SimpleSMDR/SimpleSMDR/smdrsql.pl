use strict;
use IO::Socket;
use POSIX;
use Config::Simple;
use DBI;

for(;;){
# Reading configuration parameters from the config.ini file
my $cfg = new Config::Simple();
$cfg->read('config.ini');
my $host = $cfg->param("pbx");
my $port = $cfg->param("port");
print "Connecting to the PBX $host on port $port\n";
my $sock = new IO::Socket::INET(PeerAddr => $host, PeerPort => $port,Proto => "tcp",)
or die "Cannot connect to PBX at address: $host port: $port: $!";

while (<$sock>) {
s/^\0+//; # Remove leading null characters
print $_;
chomp ($_);
#$_ =~ s/^[^ ]+//;
if ($_ =~m"/") {

&TXTout;
&DBconnect;
}
} #Close While loop

sub TXTout {
my ($year, $mon, $day);
	$year = strftime '%Y', localtime;
	$mon = substr ($_, 1,2);
	$day = substr ($_, 4,2);
my $file = "$year"."-"."$mon"."-"."$day".".log";
	if (-f $file){
		open (my $fh,'>>', $file);
		print $fh "$_\n";
		close $file;
	}
	else {
		open (my $fh,'>', $file);
		print $fh "$_\n";
		close $file;
	}
}# End of filePrint routine

sub DBconnect {
# MySQL Connection parameters

my $driver   = "SQLite"; 
my $database = "simplesmdr.db";
my $dsn = "DBI:$driver:dbname=$database";
my $userid = "";
my $password = "";

my ($line, $mon, $day, $stime, $hrs, $mins, $sec, $callp, $leaddigit, $callno, $speed, $callp2, $transf, $acccode, $sysid, $callid, $callseq, $assocall, $tester);

			$mon = substr ($_, 1,2);
			$day = substr ($_, 4,2);
			$stime = substr($_, 7,8);
			$hrs = substr($_, 17,4);
			$mins = substr($_, 22,2);
			$sec = substr($_, 25,2);
			$callp = substr($_, 28,6);
			$leaddigit = substr($_, 36,1);
			$callno = substr($_, 41,25);
			$speed = substr($_, 67,1);
			$callp2 = substr($_, 69,6);
			$transf = substr($_, 87,6);
			$acccode = substr($_, 94,11);
			$sysid = substr($_, 107,3);
			$callid = substr($_, 153,8);
			$callseq = substr($_, 162,1);
			$assocall = substr($_, 164,7);
			$tester = strftime( "%Y",localtime(time));
if ($acccode == ""){$acccode = 0}
# Establish the connection which returns a DB handle
my $dbh = DBI->connect($dsn, $userid, $password, { RaiseError => 1 })  or die $DBI::errstr;
# Prepare the SQL statement
my $stmt1 = qq(INSERT INTO import (month,day,time,hrs,mins,sec,callingparty,leaddigit,calledno,speeddialind,calledparty,transferext,accountcode,sysid,callid,callseq,assocall,year) VALUES('$mon','$day','$stime','$hrs','$mins','$sec','$callp','$leaddigit','$callno','$speed','$callp2','$transf','$acccode','$sysid','$callid','$callseq','$assocall','$tester');") or die $DBI::errstr;
# Send the statement to the server
my $rv1 = $dbh->do($stmt1) or die $DBI::errstr;
# Close the database connection
$dbh->disconnect or die $DBI::errstr;
} #Close DBconnect subroutine

#close the socket
close $sock or die "close: $!";
print "socket closed";
print "<br />";
}
