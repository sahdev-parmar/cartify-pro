<h1>hello auth</h1>
  <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                Logout
            </button>
        </form>