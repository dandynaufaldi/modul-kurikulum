{% extends 'layout.volt' %}

{% block title %}Form Kurikulum{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-12 pull-left"><h2>Form Kurikulum</h2></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-5 pull-left">
            <a href="{{ url('kurikulum/')}}" class="btn btn-secondary btn-sm" role="button">Kembali</a>
        </div>
    </div>
    <br>
    {{ form(action, 'method': 'POST')}}
    <input type="hidden" class="form-control" id="id" name="id" {% if kurikulum %}value="{{ kurikulum.id }}"{% endif %}>
    <div class="row">
        <div class="col-md-6">    
            <div class='form-group'>
                <label for='prodi'>Program Studi</label>
                <select class="form-control" name="prodi" required>
                    {% for programStudi in listProgramStudi %}
                        <option value="{{ programStudi.kode }}" {% if kurikulum and programStudi.kode == kurikulum.programStudi.kode %} selected {% endif %}>{{ programStudi.nama }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class='form-group'>
                <label for='nama_indonesia'>Nama Kurikulum</label>
                <input type="text" class="form-control" id="nama_indonesia" name="nama_indonesia" required {% if kurikulum %}value="{{ kurikulum.namaIndonesia }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='nama_inggris'>Nama Inggris</label>
                <input type="text" class="form-control" id="nama_inggris" name="nama_inggris" required {% if kurikulum %}value="{{ kurikulum.namaInggris }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='sks_lulus'>Jumlah SKS Lulus</label>
                <input type="text" class="form-control" id="sks_lulus" name="sks_lulus" required {% if kurikulum %}value="{{ kurikulum.sksLulus }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='sks_wajib'>Jumlah SKS Wajib</label>
                <input type="text" class="form-control" id="sks_wajib" name="sks_wajib" required {% if kurikulum %}value="{{ kurikulum.sksWajib }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='sks_pilihan'>Jumlah SKS Pilihan</label>
                <input type="text" class="form-control" id="sks_pilihan" name="sks_pilihan" required {% if kurikulum %}value="{{ kurikulum.sksPilihan }}"{% endif %}>
            </div>
        </div>
        <div class="col-md-6">
            <div class='form-group'>
                <label for='semester_normal'>Jumlah Semester Normal</label>
                <input type="text" class="form-control" id="semester_normal" name="semester_normal" required {% if kurikulum %}value="{{ kurikulum.semesterNormal }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='semester_mulai'>Semester Mulai</label>
                <select class="form-control" name="semester_mulai" required>
                    <option value="genap" {% if kurikulum and kurikulum.semesterMulai == 'genap' %}selected{% endif %}>Genap</option>
                    <option value="ganjil" {% if kurikulum and kurikulum.semesterMulai == 'ganjil' %}selected{% endif %}>Ganjil</option>
                </select>
            </div>
            <div class='form-group'>
                <label for='tahun_mulai'>Tahun Mulai</label>
                <select class="form-control" name="tahun_mulai" required>
                    {% for i in 1990..2100 %}
                        <option value="{{ i }}" {% if kurikulum and kurikulum.tahunMulai == i %}selected{% endif %}>{{ i }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class='form-group'>
                <label for='tahun_selesai'>Tahun Selesai</label>
                <select class="form-control" name="tahun_selesai" required>
                    {% for i in 1990..2100 %}
                        <option value="{{ i }}" {% if kurikulum and kurikulum.tahunSelesai == i %}selected{% endif %}>{{ i }}</option>
                    {% endfor %}
                </select>
            </div>
            {{ submit_button('Simpan', 'type': 'button', 'class': 'btn btn-primary btn-sm') }}
        </div>
    </div>
    {{ end_form() }}

{% endblock %}