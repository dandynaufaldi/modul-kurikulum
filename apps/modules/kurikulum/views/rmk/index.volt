{% extends 'layout.volt' %}

{% block title %}Daftar RMK{% endblock %}

{% block assets %}
{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-12 pull-left"><h2>Daftar RMK</h2></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-5 pull-left">
            <a href="{{ url('rmk/add') }}" class="btn btn-success btn-sm" role="button">Tambah RMK</a>
        </div>
    </div>
    <br>
    <table id="daftar-rmk" class="table table-stdiped table-bordered" style="width:100%;">
        <thead>
            <tr>
                <th>Kode RMK</th>
                <th>Nama RMK</th>
                <th>Ketua</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        {% for rmk in listRMK %}
        <tr>
            <td>{{ rmk['kode'] }}</td>
            <td>{{ rmk['namaIndonesia'] }}</td>
            <td>{{ rmk['namaKetua'] }}</td>
            <td>
            <div class="pull-left">
                <a href="{{ url('rmk/' ~ rmk['id'] ~'/edit') }}" class="btn btn-info btn-sm" role="button">Edit</a>
            </div>
            <div class="pull-right">
                {{ form('rmk/' ~ rmk['id'] ~ '/delete', 'method': 'POST', 'onsubmit' : "return confirm('Apakah yakin untuk menghapus " ~ rmk['namaIndonesia'] ~ "?')")}}
                    {{ hidden_field('id', 'value': rmk['id'] ) }}
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
    $('#daftar-rmk').DataTable({
        scrollX: true,
        "order": [],
    });
})
</script>
{% endblock %}