{% extends 'layout.volt' %}

{% block title %}Daftar Kurikulum{% endblock %}

{% block assets %}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-9 pull-left"><h2>Daftar Kurikulum</h2></div>
        <div class="col-md-3 pull-right">
            <a href="{{ url('kurikulum/add') }}" class="btn btn-success btn-sm" role="button">Tambah Kurikulum</a>
        </div>
    </div>
    
    <table id="daftar-kurikulum" class="table table-stdiped table-bordered" style="width:100%;">
        <thead>
            <tr>
                <th>Nama Kurikulum</th>
                <th>Program Studi</th>
                <th>Tahun</th>
                <th>Semester Normal</th>
                <th>Total SKS Lulus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        {% for kurikulum in listKurikulum %}
        <tr>
            <td>{{ kurikulum.namaIndonesia }}</td>
            <td>{{ kurikulum.programStudi.nama }}</td>
            <td>{{ kurikulum.tahunMulai }}</td>
            <td>{{ kurikulum.semesterNormal }}</td>
            <td>{{ kurikulum.sksLulus }}</td>
            <td>
            <div class="pull-left">
                <a href="{{ url('kurikulum/' ~ kurikulum.id ~'/edit') }}" class="btn btn-info btn-sm" role="button">Edit</a>
            </div>
            <div class="pull-right">
                {{ form('kurikulum/' ~ kurikulum.id ~ '/delete', 'method': 'POST', 'onsubmit' : "return confirm('Apakah yakin untuk menghapus data?')")}}
                    {{ hidden_field('kurikulum_id', 'value': kurikulum.id ) }}
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(){
    $('#daftar-kurikulum').DataTable({
        scrollX: true,
        "order": [],
    });
})
</script>
{% endblock %}