<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{% block title %}{% endblock %} &bullet; Kurikulum</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    {% block styles %}
    {% endblock %}

</head>
<body>
    <main role="main" class="container">

    {% block content %}{% endblock %}

    </main>

    <script src="{{ url('assets/js/jquery-3.4.1.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>

    {% block scripts %}{% endblock %}
</body>
</html>


