<!--controls-->
<div class="ui segment">

    <a href="{{ url.get() }}cowtype/admin/add" class="ui button positive">
        <i class="icon plus"></i> {{ helper.at('Add New') }}
    </a>

</div>
<!--/end controls-->

<table class="ui table very compact celled">
    <thead>
    <tr>
        <th style="width: 100px"></th>
        <th>{{ helper.at('Name') }}</th>
        <th>{{ helper.at('Description') }}</th>
    </tr>
    </thead>
    <tbody>
    {% for user in entries %}
        <tr>
            {% set url = url.get() ~ 'cowtype/admin/edit/' ~ user.getId() %}
            <td><a href="{{ url }}" class="mini ui icon button"><i class="pencil icon"></i></a></td>
            <td><a href="{{ url }}">{{ user.getName() }}</a></td>
            <td>{{ user.getDescription() }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>