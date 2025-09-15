<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>                        
            <th>Code</th>
            <th style="text-align:right"></th>
        </tr>
    </thead>
    <tbody>

        @foreach($widgets as $widget)
        <tr>
            <td class="col-md-6 item-name"><a href="{{ url('admin/widgets/'.$widget->id) }}" target="_blank" title="View">{{ $widget->name }}</a></td>
            <td class="col-md-1">
                @if($widget->code == '' )
                <span class="label label-warning">empty</span>
                @else <span class="label label-success">filled</span> 
                @endif
            </td>
            <td class="col-md-2 col-xs-3" align="right">

                <a href="{{ url('admin/widgets') }}/{{ $widget->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>                
            </td>
        </tr>
        @endforeach

    </tbody>
</table>