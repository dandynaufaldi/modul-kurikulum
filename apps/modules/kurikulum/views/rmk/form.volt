{% extends 'layout.volt' %}

{% block title %}Form RMK{% endblock %}

{% block content %}
    {{ flashSession.output() }}
    <div class="row">
        <div class="col-md-12 pull-left"><h2>Form RMK</h2></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-5 pull-left">
            <a href="{{ url('rmk/')}}" class="btn btn-secondary btn-sm" role="button">Kembali</a>
        </div>
    </div>
    <br>
    {{ form(action, 'method': 'POST')}}
    <input type="hidden" class="form-control" id="id" name="id" {% if rmk %}value="{{ rmk.id }}"{% endif %}>
    <div class="row">
        <div class="col-md-6">    
            <div class='form-group'>
                <label for='ketua-rmk'>Ketua RMK</label>
                <select class="form-control" name="ketua_identifier" required>
                    {% for user in listUser %}
                        <option value="{{ user.identifier }}" {% if rmk and user.identifier == rmk.ketua.identifier %} selected {% endif %}>{{ user.nama }}</option>
                    {% endfor %}
                </select>
            </div>
            <div class='form-group'>
                <label for='kode_rmk'>Kode RMK</label>
                <input type="text" class="form-control" id="kode_rmk" name="kode_rmk" required {% if rmk %}value="{{ rmk.kode }}"{% endif %}>
            </div>
        </div>
        <div class="col-md-6">
            <div class='form-group'>
                <label for='nama_indonesia'>Nama RMK</label>
                <input type="text" class="form-control" id="nama_indonesia" name="nama_indonesia" required {% if rmk %}value="{{ rmk.namaIndonesia }}"{% endif %}>
            </div>
            <div class='form-group'>
                <label for='nama_inggris'>Nama Inggris</label>
                <input type="text" class="form-control" id="nama_inggris" name="nama_inggris" required {% if rmk %}value="{{ rmk.namaInggris }}"{% endif %}>
            </div>
            {{ submit_button('Simpan', 'type': 'button', 'class': 'btn btn-primary btn-sm') }}
        </div>
    </div>
    {{ end_form() }}

{% endblock %}