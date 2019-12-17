{% extends 'layout.volt' %}

{% block title %}Tambah RMK{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-12 pull-left"><h2>Tambah RMK</h2></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-5 pull-left">
            <a href="{{ url('rmk/')}}" class="btn btn-secondary btn-sm" role="button">Kembali</a>
        </div>
    </div>
    <br>
    {{ form(action, 'method': 'POST')}}
    <div class="row">
        <div class="col-md-6">    
            <div class='form-group'>
                <label for='ketua-rmk'>Ketua RMK</label>
                <select class="form-control" name="ketua_identifier" required>
                    {% for user in listUser %}
                        <option value="{{ user.identifier }}">{{ user.nama }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class='form-group'>
                <label for='kode_rmk'>Kode RMK</label>
                <input type="text" class="form-control" id="kode_rmk" name="kode_rmk" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class='form-group'>
                <label for='nama_indonesia'>Nama RMK</label>
                <input type="text" class="form-control" id="nama_indonesia" name="nama_indonesia" required>
            </div>
            <div class='form-group'>
                <label for='nama_inggris'>Nama Inggris</label>
                <input type="text" class="form-control" id="nama_inggris" name="nama_inggris" required>
            </div>
            {{ submit_button('Simpan', 'type': 'button', 'class': 'btn btn-primary btn-sm') }}
        </div>
    </div>
    {{ end_form() }}

{% endblock %}