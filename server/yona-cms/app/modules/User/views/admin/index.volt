<!--controls-->
<div class="ui segment">

    <a href="{{ url.get() }}user/admin/add" class="ui button positive">
        <i class="icon plus"></i> {{ helper.at('Add New') }}
    </a>

</div>
<!--/end controls-->

<table class="ui table very compact celled">
    <thead>
    <tr>
        <th style="width: 100px"></th>
        <th>{{ helper.at('Phone number') }}</th>
        <th>{{ helper.at('Address') }}</th>
        <th>{{ helper.at('Name') }}</th>
        <th>{{ helper.at('Role') }}</th>
        <th>{{ helper.at('Active') }}</th>
    </tr>
    </thead>
    <tbody>
    {% for user in entries %}
        <tr>
            {% set url = url.get() ~ 'user/admin/edit/' ~ user.getId() %}
            <td><a href="{{ url }}" class="mini ui icon button"><i class="pencil icon"></i></a></td>
            <td><a href="{{ url }}">{{ user.getPhoneNumber() }}</a></td>
            <td>{{ user.getAddress() }}</td>
            <td>{{ user.getName() }}</td>
            <td>{{ user.getRoleTitle() }}</td>
            <td>{% if user.getActive() %}<i class="icon checkmark green"></i>{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>