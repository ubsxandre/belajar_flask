from flask import Flask, render_template, request, redirect, url_for, flash # manggil library
from flask_mysqldb import MySQL # library untuk konek ke MySQL
from datetime import datetime
import MySQLdb.cursors
import re

app = Flask(__name__) #
mysql = MySQL(app)
dt = datetime.strptime('2017-10-28', '%Y-%m-%d')

app.secret_key = 'inipassword' # untuk proteksi extra

app.config['MYSQL_HOST']='localhost'  # dikoneksikan dengan database
app.config['MYSQL_USER']='root'
app.config['MYSQL_PASSWORD']=''
app.config['MYSQL_DB']='ubs_univ'



# Tes koneksi ke mysql
"""
@app.route('/')
def users():
    cur = mysql.connection.cursor()
    cur.execute('''SELECT * from m_admin_ubs_univ''') # Coba exec query 
    rv = cur.fetchall()
    return str(rv) # Cetak hasil query ke dalam format string

if __name__ == '__main__':
    app.run(debug=True)
"""


# ------------------------------------- Home 
@app.route('/')                       # otomatis memetakan ke URL default (localhost) 127.0.0.1:5000
def home():                           # fungsi home() dipanggil ketika URL default di akses
  return render_template('home.php')



# ------------------------------------- Tampilan Master

@app.route('/tabel-karyawan')         # URL 127.0.0.1:5000/tabel-karyawan untuk menampilkan data karyawan dari database
def tabel():                          # function
  cur = mysql.connection.cursor()     # akses ke database
  cur.execute('SELECT NIK, FIRST_NAME, LAST_NAME, GOLONGAN, TGL_KERJA, STATUS_AKTIF, TGL_INPUT FROM zzz_dummy_table ORDER BY tgl_input') 
  #cur.execute('SELECT * FROM zzz_dummy_table ORDER BY tgl_input')
  data=cur.fetchall()                 # Fetch data dari query Select
  cur.close()
  return render_template('tabel.php', dummy = data) # redirect ke tabel.php

@app.route('/tabel-gaji')             # URL 127.0.0.1:5000/tabel-karyawan untuk menampilkan data gaji dari database
def tabel_gaji():
  cur = mysql.connection.cursor()
  cur.execute('SELECT tanggal_gajian, nik, salary, gaji_ke FROM zzz_dummy_salary ORDER BY nik, gaji_ke')
  #cur.execute('SELECT * FROM zzz_dummy_table ORDER BY tgl_input')
  data=cur.fetchall()
  cur.close()
  return render_template('tabel_gaji.php', dummy = data)


# ============================================ CRUD
# -------------------------------------------- Insert
@app.route('/insert', methods=['GET', 'POST'])
def nginputcoy():
  # submited
  if request.method == 'POST' and 'nik' in request.form and 'first_name' in request.form and 'last_name' in request.form and 'golongan' in request.form and 'tgl_kerja' in request.form: 
    
    nik = request.form['nik']         # variabel untuk menyimpan value dari form di modal tabel.php
    fn = request.form['first_name']
    ln = request.form['last_name']
    gol = request.form['golongan']
    tgl_kerja = request.form['tgl_kerja']
    sts_aktif = request.form['sts_aktif']

    # Cek di tabel zzz_dummy_table apakah sudah ada record nik yang sudah tersimpan ?
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute('SELECT * FROM zzz_dummy_table WHERE nik = %s', (nik,))
    sudahada = cursor.fetchone() 

    if sudahada:    # jika sudah maka akan muncul notifikasi dan tidak menjalankan query insert
        flash('Nik sudah pernah diinput !!') 
    elif not nik or not fn or not ln or not gol:  # jika form masih ada yang kosong maka kan ada notif dan tidak menjalankan query insert
        flash('Form harus terisi semua !!')       # flash adalah library tambahan untuk menyimpan message tanpa harus membuat variabel baru
    else:
        # NIK belum pernah di input dan form sudah terisi semua. Menjalankan query insert ke database
        cursor.execute('''INSERT INTO zzz_dummy_table (TGL_INPUT, NIK, FIRST_NAME, LAST_NAME, GOLONGAN, STATUS_AKTIF, TGL_KERJA) VALUES (SYSDATE(), %s, %s, %s, %s, %s, STR_TO_DATE(%s, '%%Y-%%m-%%dT%%H:%%i'))''', (nik, fn, ln, gol, sts_aktif,tgl_kerja))
        mysql.connection.commit()                 # commit setelah insert
        flash("Data Inserted Successfully")
  elif request.method == 'POST':          
        # Form is empty... (no POST data)     
        flash('Mohon isi form nya !!')
    # Show registration form with message (if any)
  return redirect(url_for('tabel'))               # redirect function tabel


@app.route('/insert-gaji', methods=['GET', 'POST'])
def semoga_naik_gaji():
  # submited
  if request.method == 'POST' and 'tgl_gajian' in request.form and 'nik' in request.form and 'gaji' in request.form: 
    nik = request.form['nik']           # membuat variabel untuk menyimpan value dari form_nginput
    tg = request.form['tgl_gajian']
    gj = request.form['gaji']

    # Cek di tabel zzz_dummy_salary apakah sudah ada record nik yang sudah tersimpan ?
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute('SELECT * FROM zzz_dummy_salary WHERE nik = %s AND tanggal_gajian= %s', (nik, tg))
    sudahada = cursor.fetchone() 

    if sudahada:
        flash('Data sudah ada !!') 
    elif not nik or not tg or not gj:
        flash('Masih ada form yang belum terisi !!') 
    else:
        cursor.execute('INSERT INTO zzz_dummy_salary (GAJI_KE, NIK, TANGGAL_GAJIAN, SALARY) VALUES (f_gaji_ke(%s), %s, %s, %s)', (nik, nik, tg, gj,))
        mysql.connection.commit()
        flash("Data Inserted Successfully")
  elif request.method == 'POST':
        flash('Mohon diisi formnya !!')
  return redirect(url_for('tabel_gaji'))        




# -------------------------------------------- Delete

@app.route('/delete/<string:nik>', methods = ['GET'])
def delete(nik):
    flash("Berhasil delete !")
    cur = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cur.execute("DELETE FROM zzz_dummy_table WHERE nik=%s", (nik,))
    mysql.connection.commit()
    return redirect(url_for('tabel'))


@app.route('/delete-gaji/<string:nik>,<string:gaji_ke>', methods = ['POST','GET'])
def delete_gaji(nik, gaji_ke):
    flash("Berhasil delete !")
    cur = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cur.execute("DELETE FROM zzz_dummy_salary WHERE nik=%s AND gaji_ke=%s", (nik, gaji_ke))
    mysql.connection.commit()
    return redirect(url_for('tabel_gaji'))



# -------------------------------------------- Update 

@app.route('/update',methods=['POST','GET'])
def update():

    if request.method == 'POST':
        nik = request.form['nik']
        fn = request.form['first_name']
        ln = request.form['last_name']
        gol = request.form['golongan']
        tgl_kerja = request.form['tgl_kerja']
        
        cur = mysql.connection.cursor()
        cur.execute("""
               UPDATE zzz_dummy_table
               SET FIRST_NAME=%s,
                  LAST_NAME=%s,
                  GOLONGAN=%s
               WHERE nik=%s
            """, (fn, ln, gol, nik))
        flash("Data Karyawan Updated Successfully")
        mysql.connection.commit()
        return redirect(url_for('tabel'))


@app.route('/update-gaji', methods=['GET', 'POST'])
def semoga_lebih_baik():

    if request.method == 'POST':
        nik = request.form['nik']
        tg = request.form['tanggal_gajian']
        gk = request.form['gaji_ke']
        p_gk = request.form['p_gaji_ke']
        gj = request.form['gaji']
        
        cur = mysql.connection.cursor()
        # cur.execute('SELECT * FROM zzz_dummy_salary WHERE nik = %s AND gaji_ke= %s', (nik, gk))
        # sudahada = cur.fetchone() 

        # if sudahada:
        #   flash('Data sudah ada, Gagal Update !!') 
        # elif not nik or not tg or not gj:
        #   flash('Isinen kabeh !!') 
        # else:

        cur.execute("""
              UPDATE zzz_dummy_salary
              SET tanggal_gajian=%s,
                salary=%s
              WHERE nik=%s
              AND gaji_ke = %s
          """, (tg, gj, nik, p_gk))
        flash("Data Gaji Updated Successfully")
        mysql.connection.commit()
      
    # elif request.method == 'POST':
    #   flash('Isinen kabeh !!')
    # Show registration form with message (if any)
        return redirect(url_for('tabel_gaji'))




# ============================================ Report / Combine data
# --------------------------------------------

@app.route('/report-gaji-karyawan')
def report_gaji_karyawan():             # function untuk menampilkan data hasil combine dari tabel karyawan dan tabel gaji
  cur = mysql.connection.cursor()
  cur.execute('''SELECT a.NIK,
                CONCAT(a.FIRST_NAME, a.LAST_NAME) AS NAMA,
                a.GOLONGAN,
                b.TANGGAL_GAJIAN,
                b.GAJI_KE,
                b.SALARY,
                DATE_FORMAT(A.TGL_KERJA ,'%Y-%m-%d') AS TGL_MASUK_KERJA,
                CASE 
                    WHEN a.STATUS_AKTIF = '1'
                    THEN 'AKTIF'
                    ELSE 'TIDAK AKTIF'
                END AS STATUS_KARYAWAN
            FROM zzz_dummy_table a, zzz_dummy_salary b
            WHERE a.NIK = b.NIK
            ORDER BY A.NIK, B.GAJI_KE;''')
  #cur.execute('SELECT * FROM zzz_dummy_table ORDER BY tgl_input')
  data=cur.fetchall()
  cur.close()
  return render_template('report_karyawan.php', dummy = data)



if __name__ == '__main__':
  app.run(debug=True)