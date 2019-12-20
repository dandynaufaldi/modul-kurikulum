{% extends 'layout.volt' %}

{% block title %}Form Mata Kuliah{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-12 pull-left"><h2>Form Mata Kuliah</h2></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-5 pull-left">
            <a href="{{ url('kurikulum/' ~ kurikulum_id ~ '/matakuliah')}}" class="btn btn-secondary btn-sm" role="button">Kembali</a>
        </div>
    </div>
    <br>
    {{ form(action, 'method': 'POST')}}
    <input type="hidden" class="form-control" id="id" name="id" {% if mataKuliah %}value="{{ mataKuliah.id }}"{% endif %}>
    <div class="row">
        <div class="col-md-6">
            <div class='form-group'>
                <label for='kode_rmk'>RMK</label>
                <select class="form-control" name="kode_rmk" required>
                    {% for rmk in listRmk %}
                        <option value="{{ rmk.kode }}" {% if mataKuliah and rmk.kode == mataKuliah.rmk.kode %} selected {% endif %}>{{ rmk.namaIndonesia }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class='form-group'>
                <label for='kode_mata_kuliah'>Kode Mata Kuliah</label>
                <input type="text" class="form-control" id="kode_mata_kuliah" name="kode_mata_kuliah" required {% if mataKuliah %}value="{{ mataKuliah.kode }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='nama_indonesia'>Nama Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_indonesia" name="nama_indonesia" required {% if mataKuliah %}value="{{ mataKuliah.namaIndonesia }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='nama_inggris'>Nama Inggris</label>
                <input type="text" class="form-control" id="nama_inggris" name="nama_inggris" required {% if mataKuliah %}value="{{ mataKuliah.namaInggris }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='nama_inggris'>SKS</label>
                <input type="number" class="form-control" id="sks" name="sks" required {% if mataKuliah %}value="{{ mataKuliah.sks }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='nama_inggris'>Semester</label>
                <input type="number" class="form-control" id="semester" name="semester" required {% if mataKuliah %}value="{{ mataKuliah.semester }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='deskripsi'>Deskripsi</label>
                <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" required>{% if mataKuliah %}{{ mataKuliah.deskripsi }}{% endif %}</textarea>
            </div>
            <div class='form-group'>
                <label for='sifat'>Sifat</label>
                <select class="form-control" name="sifat" required>
                    <option value="wajib">Wajib</option>
                    <option value="pilihan">Pilihan</option>
                </select>
            </div>
            {{ submit_button('Simpan', 'type': 'button', 'class': 'btn btn-primary btn-sm') }}
        </div>
    </div>
    {{ end_form() }}

{% endblock %}