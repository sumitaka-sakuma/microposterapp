@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="column col-md-10">
      <div class="card">
        <div class="card-header">{{ $user->name }}のプロフィール</div>
          <div class="card-body">
        
          <img src="{{ asset('storage/profiles/'.$user->profile_image) }}" alt="プロフィール画像" style="width:100px; height:100px;">

          <div class="btn-toolbar">
              <div class="btn-group">
                <form method="GET" action="{{ route('users.followings', ['id' => $user->id ])}}">
                  @csrf
                  <div class="form-group">
                    <div class="text-right">  
                      <input class="btn btn-outline-info " type="submit" value="フォロー一覧：{{ $user->follows->count() }}"> 
                    </div>
                  </div>
                </form>

                <form method="GET" action="{{ route('users.followers', ['id' => $user->id ])}}">
                  @csrf
                  <div class="form-group">
                    <div class="text-right">
                      <input class="btn btn-outline-secondary " type="submit" value="フォロワー一覧：{{ $user->followers->count() }}"> 
                    </div>
                  </div>
                </form>

                <form method="GET" action="{{ route('users.likes', ['id' => $user->id] )}}">
                @csrf
                  <div class="form-group">
                    <div class="text-right">
                      <input class="btn btn-outline-success" type="submit" value="いいねした投稿：{{ $user->likes->count() }}">
                    </div>
                  </div>
                </form>

              </div>
            </div> 
        
          @if(auth()->user()->isFollowed($user->id))
            <div>
              <span class="px-1 bg-secondary text-light">フォローされています</span>
            </div>
          @endif
          @if(Auth::id() != $user->id )
            @if(auth()->user()->isFollowing($user->id))
              <form method="POST" action="{{ route('unfollow', ['id' => $user->id ])}}">
                @csrf
                {{ method_field('DELETE') }}
                        
                <div class="form-group">
                  <div class="text-right">
                    <button type="submit" class="btn btn-danger">フォロー解除</button>
                  </div>
                </div>
              </form>
            @else
              <form method="POST" action="{{ route('follow', ['id' => $user->id ])}}">
                @csrf
                <div class="form-group">
                  <div class="text-right">
                    <button type="submit" class="btn btn-primary">フォローする</button>
                  </div>
                </div>
              </form>
            @endif
          @endif

          <table class="table" width="100%" style="table-layout:fixed;">
            <thead>
              <tr>
                <th scope="col" style="width:20%;">ユーザー名</th>   
                <th scope="col" style="width:15%;">生年月日</th>
                <th scope="col" style="width:10%;">年齢</th>
                <th scope="col" style="width:10%;">性別</th>
                <th scope="col" style="width:45%;">自己紹介</th>   
             </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:20%;">{{ $user->name }}</td>
                <td style="width:15%;">{{ $user->birthday }}</td>
                @if(empty($user->birthday))
                  <td style="width:10%;"></td>
                @else
                  <td style="width:10%;">{{ $age->y }}歳</td>
                @endif
                <td style="width:10%;">{{ $gender}}</td>
                <td style="width:45%;">{{ $user->self_introduction }}</td>
              </tr>
            </tdoby>
          </table>  

          @if(Auth::id() === $user->id)
            <div class="btn-toolbar">
              <div class="btn-group">
                <form method="GET" action="{{ route('users.edit', ['id' => $user->id ])}}">
                  @csrf
                  <div class="form-group">
                    <div class="text-right">
                      <input class="btn btn-info " type="submit" value="編集"> 
                    </div>
                  </div>
                </form>

                <form method="GET" action="{{ route('microposts.create', ['id' => $user->id ])}}">
                  @csrf
                  <div class="form-group">
                    <div class="text-right">
                      <input class="btn btn-secondary " type="submit" value="投稿"> 
                    </div>
                  </div>
                </form>
              </div>
            </div>
          @endif  

          <label>これまで{{ $microposts->count() }}件投稿しています。</label>

          <table class="table table-striped" width="100%" style="table-layout:fixed;">
            <thead>
              <tr>
                <th scope="col" style="width:50%;">投稿一覧</th> 
                <th scope="col" style="width:20%;" ></th> 
                @if(Auth::id() === $user->id)
                  <th scope="col" style="width:10%;"></th>
                  <th scope="col" style="width:10%;"></th>
                  <th scope="col" style="width:10%;"></th>
                @endif  
              </tr>
            </thead>
            <tbody>
              @foreach($microposts as $micropost)
                <tr>
                  <td style="width:50%;">
                    <div>
                      <p>{{ $micropost->content}}</p>
                    </div>
                  </td>
                  @if(empty($micropost->updated_at))
                    <td style="width:15%;">
                      {{ $micropost->created_at}}
                    </td>
                  @else  
                    <td style="width:20%;">
                      <label>{{ $micropost->updated_at}}</label>
                    </td>
                  @endif
                  @if(Auth::id() === $user->id)
                    <td style="width:10%;"> 
                      <form method="GET" action="{{ route('microposts.show', ['id' => $micropost->id ])}}">
                      @csrf
                        <div class="form-group">
                          <div class="text-right">
                            <input class="btn btn-success" type="submit" value="詳細"> 
                          </div>
                        </div>
                      </form>
                    </td>
                    <td style="width:10%;">
                      <form method="GET" action="{{ route('microposts.edit', ['id' => $micropost->id ])}}">
                        @csrf
                        <div class="form-group">
                          <div class="text-right">
                            <input class="btn btn-info" type="submit" value="編集"> 
                          </div>
                        </div>
                      </form>
                    </td>
                    <td style="width:10%">
                      <form method="POST" action="{{ route('microposts.destroy', ['id' => $micropost->id ])}}" id="delete_{{ $micropost->id }}">
                      @csrf
                        <div class="form-group">
                          <div class="text-right">
                            <input class="btn btn-danger " type="submit" value="削除"> 
                          </div>
                        </div>
                      </form>
                    </td>
                  @endif
              @endforeach
              </tr>
            </tdoby>
          </table>

          {{ $microposts->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<script>
function deletePost(e){
    'use strict'
    if(confirm('本当に削除してもよろしいですか？')){
        document.getElementById('delete_' + e.dataset.id).submit();
    }
}
</script>