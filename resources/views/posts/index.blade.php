<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KANTIN.STIKI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body style="background-color: bisque">
    <div class="container p-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">
                        KANTIN STIKI
                    </h3>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('posts.create') }}" class="btn btn-md btn-success mb-3">TAMBAH POST</a>
                            </div>
                            <div class="col">
                                <form class="d-flex" role="search" action="{{ route('posts.index') }}" method="GET">
                                    <input class="form-control me-2" type="search" name="query" placeholder="Search..." aria-label="Search" value="{{ old('query') }}">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>                                
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Tenant</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($posts as $post)
                                <tr class="text-center">
                                    <td>
                                        <img src="{{ asset('/storage/posts/'.$post->image) }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $post->tenant }}</td>
                                    <td>{{ $post->menu }}</td>
                                    <td>Rp. {{ $post->price }}</td>
                                    <td>
                                        <form onsubmit="return confirm('Are you sure ?');" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data Post Is Empty!
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item {{ ($posts->currentPage() == 1) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $posts->url(1) }}" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                        <li class="page-item {{ ($posts->currentPage() == $i) ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ ($posts->currentPage() == $posts->lastPage()) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $posts->url($posts->currentPage()+1) }}">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'Successed!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'Fail!'); 
            
        @endif
    </script>

</body>
</html>