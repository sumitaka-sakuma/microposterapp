@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="column col-md-9">
      <div class="card">
        <div class="card-header">いいねした人の一覧</div>
          <div class="card-body">
            
            <table class="talbe" width="100%" style="table-layout:fixed;">
              <tbody>
                @foreach($like_users as $like_user)
                <tr>
                  
                  <td style="width:20%;">{{$like_user->user->name}}</td>
                  
                @endforeach
                
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection