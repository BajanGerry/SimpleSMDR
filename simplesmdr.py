import os
import socket
import sqlite3
from datetime import datetime
import configparser
from flask import Flask, request, render_template_string

app = Flask(__name__)

def read_config():
    config = configparser.ConfigParser()
    config.read('config.ini')
    return (
        config['DEFAULT']['pbx'],
        int(config['DEFAULT']['port']),
        config['DEFAULT']['db_name'],
        {
            'mon': (int(config['FIELDS']['mon_start']), int(config['FIELDS']['mon_end'])),
            'day': (int(config['FIELDS']['day_start']), int(config['FIELDS']['day_end'])),
            'stime': (int(config['FIELDS']['stime_start']), int(config['FIELDS']['stime_end'])),
            'hrs': (int(config['FIELDS']['hrs_start']), int(config['FIELDS']['hrs_end'])),
            'mins': (int(config['FIELDS']['mins_start']), int(config['FIELDS']['mins_end'])),
            'sec': (int(config['FIELDS']['sec_start']), int(config['FIELDS']['sec_end'])),
            'callp': (int(config['FIELDS']['callp_start']), int(config['FIELDS']['callp_end'])),
            'leaddigit': (int(config['FIELDS']['leaddigit_start']), int(config['FIELDS']['leaddigit_end'])),
            'callno': (int(config['FIELDS']['callno_start']), int(config['FIELDS']['callno_end'])),
            'speed': (int(config['FIELDS']['speed_start']), int(config['FIELDS']['speed_end'])),
            'callp2': (int(config['FIELDS']['callp2_start']), int(config['FIELDS']['callp2_end'])),
            'transf': (int(config['FIELDS']['transf_start']), int(config['FIELDS']['transf_end'])),
            'acccode': (int(config['FIELDS']['acccode_start']), int(config['FIELDS']['acccode_end'])),
            'sysid': (int(config['FIELDS']['sysid_start']), int(config['FIELDS']['sysid_end'])),
            'callerid': (int(config['FIELDS']['callerid_start']), int(config['FIELDS']['callerid_end'])),
            'callid': (int(config['FIELDS']['callid_start']), int(config['FIELDS']['callid_end'])),
            'callseq': (int(config['FIELDS']['callseq_start']), int(config['FIELDS']['callseq_end'])),
            'assocall': (int(config['FIELDS']['assocall_start']), int(config['FIELDS']['assocall_end'])),
        }
    )

def ensure_dir(dirname):
    if not os.path.exists(dirname):
        os.makedirs(dirname)

def log_to_file(line):
    year = datetime.now().strftime('%Y')
    mon = line[1:3]
    day = line[4:6]
    filename = f"data/{year}-{mon}-{day}.log"
    ensure_dir('data')
    with open(filename, 'a') as f:
        f.write(line + '\n')

def db_connect(line, db_name, fields):
    mon = line[fields['mon'][0]:fields['mon'][1]]
    day = line[fields['day'][0]:fields['day'][1]]
    stime = line[fields['stime'][0]:fields['stime'][1]]
    hrs = line[fields['hrs'][0]:fields['hrs'][1]]
    mins = line[fields['mins'][0]:fields['mins'][1]]
    sec = line[fields['sec'][0]:fields['sec'][1]]
    callp = line[fields['callp'][0]:fields['callp'][1]]
    leaddigit = line[fields['leaddigit'][0]:fields['leaddigit'][1]]
    callno = line[fields['callno'][0]:fields['callno'][1]]
    speed = line[fields['speed'][0]:fields['speed'][1]]
    callp2 = line[fields['callp2'][0]:fields['callp2'][1]]
    transf = line[fields['transf'][0]:fields['transf'][1]]
    acccode = line[fields['acccode'][0]:fields['acccode'][1]].strip()
    sysid = line[fields['sysid'][0]:fields['sysid'][1]]
    callerid = line[fields['callerid'][0]:fields['callerid'][1]]
    callid = line[fields['callid'][0]:fields['callid'][1]]
    callseq = line[fields['callseq'][0]:fields['callseq'][1]]
    assocall = line[fields['assocall'][0]:fields['assocall'][1]]
    tester = datetime.now().strftime('%Y')

    if not acccode:
        acccode = '0'

    conn = sqlite3.connect(db_name)
    c = conn.cursor()
    c.execute('''
        INSERT INTO import
        (month, day, time, hrs, mins, sec, callingparty, leaddigit, calledno, speeddialind, calledparty, transferext, accountcode, sysid, callerid, callid, callseq, assocall, year)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ''', (mon, day, stime, hrs, mins, sec, callp, leaddigit, callno, speed, callp2, transf, acccode, sysid, callerid, callid, callseq, assocall, tester))
    conn.commit()
    conn.close()

@app.route('/')
def index():
    db_name = read_config()[2]
    conn = sqlite3.connect(db_name)
    conn.row_factory = sqlite3.Row
    c = conn.cursor()

    # Get filter values from query parameters
    filters = {k: v for k, v in request.args.items() if v}

    # Build the SQL query with filters
    query = "SELECT * FROM import WHERE 1=1"
    params = []
    for col, val in filters.items():
        query += f" AND {col} LIKE ?"
        params.append(f"%{val}%")

    c.execute(query, params)
    rows = c.fetchall()

    # Get unique values for each column for dropdowns
    columns = [
        'month', 'day', 'time', 'hrs', 'mins', 'sec', 'callingparty',
        'leaddigit', 'calledno', 'speeddialind', 'calledparty',
        'transferext', 'accountcode', 'sysid', 'callerid', 'callid',
        'callseq', 'assocall', 'year'
    ]
    options = {}
    for col in columns:
        c.execute(f"SELECT DISTINCT {col} FROM import ORDER BY {col}")
        options[col] = [str(row[0]) for row in c.fetchall() if row[0] is not None]

    conn.close()

    # Generate the HTML table with dropdown filters
    html = """
    <!DOCTYPE html>
    <html>
    <head>
        <title>PBX Call Data</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
                table-layout: fixed;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
                word-break: break-all;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            th {
                background-color: #f2f2f2;
                position: sticky;
                top: 0;
            }
            .filter-container {
                display: flex;
                flex-wrap: wrap;
                gap: 0;
                margin-bottom: 10px;
                border-bottom: 1px solid #ddd;
                padding-bottom: 10px;
            }
            .filter-item {
                padding: 0 5px;
                box-sizing: border-box;
            }
            .filter-item select {
                padding: 6px;
                box-sizing: border-box;
                width: 100%;
            }
            .filter-item label {
                display: block;
                font-size: 12px;
                margin-bottom: 2px;
                color: #666;
            }
            .filter-submit {
                margin-top: 20px;
                width: 100%;
            }
            .filter-submit input {
                padding: 8px 15px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <h1>PBX Call Data</h1>
        <form method="get" class="filter-container" id="filterForm">
            <div class="filter-item" style="flex: 1; min-width: 50px;">
                <label>Month</label>
                <select name="month" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['month'] %}
                    <option value="{{ opt }}" {% if request.args.get('month') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 50px;">
                <label>Day</label>
                <select name="day" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['day'] %}
                    <option value="{{ opt }}" {% if request.args.get('day') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 80px;">
                <label>Time</label>
                <select name="time" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['time'] %}
                    <option value="{{ opt }}" {% if request.args.get('time') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>Hours</label>
                <select name="hrs" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['hrs'] %}
                    <option value="{{ opt }}" {% if request.args.get('hrs') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>Minutes</label>
                <select name="mins" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['mins'] %}
                    <option value="{{ opt }}" {% if request.args.get('mins') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>Seconds</label>
                <select name="sec" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['sec'] %}
                    <option value="{{ opt }}" {% if request.args.get('sec') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 100px;">
                <label>Calling Party</label>
                <select name="callingparty" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['callingparty'] %}
                    <option value="{{ opt }}" {% if request.args.get('callingparty') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>Lead Digit</label>
                <select name="leaddigit" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['leaddigit'] %}
                    <option value="{{ opt }}" {% if request.args.get('leaddigit') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 120px;">
                <label>Called Number</label>
                <select name="calledno" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['calledno'] %}
                    <option value="{{ opt }}" {% if request.args.get('calledno') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 80px;">
                <label>Speed Dial</label>
                <select name="speeddialind" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['speeddialind'] %}
                    <option value="{{ opt }}" {% if request.args.get('speeddialind') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 100px;">
                <label>Called Party</label>
                <select name="calledparty" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['calledparty'] %}
                    <option value="{{ opt }}" {% if request.args.get('calledparty') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 100px;">
                <label>Transfer Ext</label>
                <select name="transferext" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['transferext'] %}
                    <option value="{{ opt }}" {% if request.args.get('transferext') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 100px;">
                <label>Account Code</label>
                <select name="accountcode" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['accountcode'] %}
                    <option value="{{ opt }}" {% if request.args.get('accountcode') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>System ID</label>
                <select name="sysid" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['sysid'] %}
                    <option value="{{ opt }}" {% if request.args.get('sysid') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 120px;">
                <label>Caller ID</label>
                <select name="callerid" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['callerid'] %}
                    <option value="{{ opt }}" {% if request.args.get('callerid') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 100px;">
                <label>Call ID</label>
                <select name="callid" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['callid'] %}
                    <option value="{{ opt }}" {% if request.args.get('callid') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>Call Sequence</label>
                <select name="callseq" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['callseq'] %}
                    <option value="{{ opt }}" {% if request.args.get('callseq') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 100px;">
                <label>Associated Call</label>
                <select name="assocall" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['assocall'] %}
                    <option value="{{ opt }}" {% if request.args.get('assocall') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-item" style="flex: 1; min-width: 60px;">
                <label>Year</label>
                <select name="year" class="filter-select">
                    <option value="">All</option>
                    {% for opt in options['year'] %}
                    <option value="{{ opt }}" {% if request.args.get('year') == opt %}selected{% endif %}>{{ opt }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class="filter-submit">
                <input type="submit" value="Filter">
            </div>
        </form>
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Hours</th>
                    <th>Minutes</th>
                    <th>Seconds</th>
                    <th>Calling Party</th>
                    <th>Lead Digit</th>
                    <th>Called Number</th>
                    <th>Speed Dial</th>
                    <th>Called Party</th>
                    <th>Transfer Ext</th>
                    <th>Account Code</th>
                    <th>System ID</th>
                    <th>Caller ID</th>
                    <th>Call ID</th>
                    <th>Call Sequence</th>
                    <th>Associated Call</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                {% for row in rows %}
                <tr>
                    <td>{{ row['month'] }}</td>
                    <td>{{ row['day'] }}</td>
                    <td>{{ row['time'] }}</td>
                    <td>{{ row['hrs'] }}</td>
                    <td>{{ row['mins'] }}</td>
                    <td>{{ row['sec'] }}</td>
                    <td>{{ row['callingparty'] }}</td>
                    <td>{{ row['leaddigit'] }}</td>
                    <td>{{ row['calledno'] }}</td>
                    <td>{{ row['speeddialind'] }}</td>
                    <td>{{ row['calledparty'] }}</td>
                    <td>{{ row['transferext'] }}</td>
                    <td>{{ row['accountcode'] }}</td>
                    <td>{{ row['sysid'] }}</td>
                    <td>{{ row['callerid'] }}</td>
                    <td>{{ row['callid'] }}</td>
                    <td>{{ row['callseq'] }}</td>
                    <td>{{ row['assocall'] }}</td>
                    <td>{{ row['year'] }}</td>
                </tr>
                {% endfor %}
            </tbody>
        </table>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.getElementById('dataTable');
                const headers = table.querySelectorAll('th');
                const selects = document.querySelectorAll('.filter-select');

                headers.forEach((header, index) => {
                    if (index < selects.length) {
                        const width = header.offsetWidth;
                        selects[index].style.width = width + 'px';
                    }
                });

                // Adjust on window resize
                window.addEventListener('resize', function() {
                    headers.forEach((header, index) => {
                        if (index < selects.length) {
                            const width = header.offsetWidth;
                            selects[index].style.width = width + 'px';
                        }
                    });
                });
            });
        </script>
    </body>
    </html>
    """
    return render_template_string(html, rows=rows, request=request, options=options)


def main():
    ensure_dir('log')
    with open('log/errlog.log', 'a') as stderr:
        os.dup2(stderr.fileno(), 2)

    host, port, db_name, fields = read_config()
    print(f"Connecting to the PBX {host} on port {port}")

    # Start the Flask app in a separate thread if you want to run both the socket listener and the web server
    import threading
    threading.Thread(target=lambda: app.run(host='0.0.0.0', port=5000, debug=False), daemon=True).start()

    while True:
        try:
            with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
                s.connect((host, port))
                while True:
                    data = s.recv(1024).decode('utf-8')
                    if not data:
                        break
                    line = data.strip('\0')
                    print(line)
                    if '/' in line:
                        log_to_file(line)
                        db_connect(line, db_name, fields)
        except Exception as e:
            print(f"Error: {e}")
            continue

if __name__ == '__main__':
    main()
