{% extends 'layout.volt' %}

{% block title %}Daftar Mata Kuliah{% endblock %}

{% block assets %}
{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-12 pull-left"><h2>Daftar Mata Kuliah</h2></div>
    </div>
    <div class="row">
        <div class="col-md-12 pull-left"><h5>{{ kurikulum.namaIndonesia }}</h5></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-1 pull-left">
            <a href="{{ url('kurikulum/')}}" class="btn btn-secondary btn-sm" role="button">Kembali</a>
        </div>
        <div class="col-md-2 pull-left">
            <a href="{{ url('kurikulum/' ~ kurikulum.id ~'/matakuliah/add') }}" class="btn btn-success btn-sm" role="button">Tambah Mata Kuliah</a>
        </div>
    </div>
    <br>
    <table id="daftar-mata-kuliah" class="table table-stdiped table-bordered" style="width:100%;">
        <thead>
            <tr>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>Kode RMK</th>
                <th>Nama RMK</th>
                <th>Semester</th>
                <th>SKS</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        {% for matakuliah in kurikulum.listMataKuliah %}
        <tr>
            <td>{{ matakuliah.kode }}</td>
            <td>{{ matakuliah.namaIndonesia }}</td>
            <td>{{ matakuliah.rmk.kode }}</td>
            <td>{{ matakuliah.rmk.namaIndonesia }}</td>
            <td>{{ matakuliah.semester }}</td>
            <td>{{ matakuliah.sks }}</td>
            <td>{{ matakuliah.deskripsi }}</td>
            <td>
                <div class="pull-left">
                    <a href="{{ url('kurikulum/' ~ kurikulum.id ~'/matakuliah/edit/' ~ matakuliah.id) }}" class="btn btn-info btn-sm" role="button">Edit</a>
                </div>
                <div class="pull-right">
                    {{ form('mata-kuliah/' ~ matakuliah.id ~ '/delete', 'method': 'POST', 'onsubmit' : "return confirm('Apakah yakin untuk menghapus " ~ matakuliah.namaIndonesia ~ "?')")}}
                        {{ hidden_field('id', 'value': matakuliah.id ) }}
                        {{ submit_button('Hapus', 'type': 'button', 'class': 'btn btn-danger btn-sm') }}
                    {{ end_form() }}
                </div>
            </td>
        </tr>
        {% endfor %}
        </tbody>
    </table>

{% endblock %}

{% block scripts %}
<script>
$(document).ready(function(){
    $('#daftar-mata-kuliah').DataTable({
        scrollX: true,
        "order": [],
    });
})
</script>
{% endblock %}