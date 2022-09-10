<div class="modal-header">
    <div>
        <h5 class="modal-title" id="exampleModalLabel">
            User Info
        </h5>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <table>
        <tr>
            <th style="width: 120px;">Name</th>
            <th style="width: 3px">:</th>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <th style="width: 120px;">Email</th>
            <th style="width: 3px">:</th>
            <td>{{$user->email}}</td>
        </tr>
        <tr>
            <th style="width: 120px;">Status</th>
            <th style="width: 3px">:</th>
            <td>{{$user->status}}</td>
        </tr>
        <tr>
            <th style="width: 120px;">Phone</th>
            <th style="width: 3px">:</th>
            <td>{{$user->phone}}</td>
        </tr>
        <tr>
            <th style="width: 120px;">CV Link</th>
            <th style="width: 3px">:</th>
            <td>
                <a href="{{$user->cv_link}}" target="_blank">
                    {{$user->cv_link}}
                </a>
            </td>
        </tr>
    </table>
</div>
