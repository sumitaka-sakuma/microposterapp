@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="column col-md-8">
      <div class="card">
        <div class="card-header">フォロー一覧</div>
          <div class="card-body">
            
            @if($users->followers->count() == 0)
              <p class="text-center">フォロワーがいません。</p>
            @endif
              <p class="text-left">{{ $users->followers->count() }}人のフォロワーがいます。

            <table class="talbe" width="100%" style="table-layout:fixed;">
              <tbody>
                @foreach($users->followers as $user)
                <tr>
                  <td style="width:15%"><img src="{{ asset('storage/profiles/'.$user->profile_image) }}" style="width:100px; height:100px;"></td>
                  <td style="width:15%"><a href="{{ route('users.show', ['id' => $user->id ]) }}">{{ $user->name }}</a></td>
                  <td style="width:30%">
                    @if (auth()->user()->isFollowed($user->id))
                      <div class="px-2">
                        <span class="px-1 bg-secondary text-light">フォローされています</span>
                      </div>
                    @endif
                  </td>
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
