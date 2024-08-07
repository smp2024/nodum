@foreach (user_permissions() as $key => $value )
    <div class="col-md-4 d-flex mb-3" >

        <div class="panel shadow">

            <div class="header">
                <h2 class="title">
                    {!! $value['icon'] !!} {!! $value['title'] !!}
                </h2>
            </div>

            <div class="inside">
                @foreach ($value['keys'] as $k => $v )
                    <div class="form-check">
                        <input type="checkbox" value="true" name="{{ $k }}" @if (kvfj($user->permissions, $k)) checked @endif>
                        <label for="{{ $k }}">
                            {{$v}}
                        </label>
                    </div>
                @endforeach
            </div>

        </div>

    </div>
@endforeach
<div  hidden="true" >

    <div class="panel shadow">

        <div class="header">
            <h2 class="title">

            </h2>
        </div>

        <div class="inside">
            <div class="form-check">
                <input type="checkbox" value="true" name="user_profile" checked>
                <input type="checkbox" value="true" name="user_profile_edit"  checked>
            </div>
        </div>

    </div>

</div>
