<nav class="font-sans flex flex-col text-center content-center sm:flex-row sm:text-left sm:justify-between py-2 px-6 bg-white shadow sm:items-baseline w-full">
    <div class="mb-2 sm:mb-0 inner">

        <a href="{{ route('dashboard') }}" class="text-2xl no-underline text-grey-darkest hover:text-blue-dark font-sans font-bold">Agenda de Contatos</a><br>
        <span class="text-xs text-grey-dark">Pedro Góes</span>

    </div>

    <div class="self-right">
        <a href="{{ route('contato') }}" class="text-md no-underline text-black hover:text-blue-dark ml-2 px-1">CRUD de Tipos de Contatos</a>
       <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    this.closest('form').submit();" class="text-md no-underline text-black hover:text-blue-dark ml-2 px-1" >
                    {{ __('Deslogar') }}
                </a>
            </form>

    </div>

</nav>
