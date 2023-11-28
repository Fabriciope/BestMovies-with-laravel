@extends('layouts.default', ['title' => 'Dashboard'])

@section('content')
    <div class="mb-8">
        <h2 class="text-xl text-zinc-100 font-bold">Dashboard</h2>
        <p class="text-lg text-zinc-200 font-normal">Add or update information about the films you registered</p>
    </div>
    <div>
      @if (count($movies) == 0)
          <h3>You don't have movies registered yet</h3>
      @else
      <table class="p-3 table-auto w-full rounded-md bg-slate-800 shadow-lg">
          <thead>
            <tr>
              <th class="p-3 text-left text-zinc-200 text-lg font-normal">Title</th>
              <th class="p-3 text-left text-zinc-200 text-lg font-normal">Rate</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($movies as $movie)
            <tr>
              <td class="p-2 text-zinc-300 text-base pl-2">{{ $movie->title }}</td>
              <td class="p-2"><i class="star fa-solid fa-star text-yellow-500 text-lg mr-1"></i><span class="text-zinc-300 text-base">Without rate</span></td>
              <td class="p-2 flex space-x-4">
                  <a href="{{ route('movie.edit', $movie->id) }}" class="py-1 px-2 rounded-md shadow-md bg-sky-600 font-bold text-sm text-center text-zinc-200">Edit</a>
                  <form action="{{ route('movie.destroy', $movie->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="py-1 px-2 rounded-md shadow-md bg-red-700 font-bold text-sm text-center text-zinc-200">Delete</button>
                  </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
@endsection
