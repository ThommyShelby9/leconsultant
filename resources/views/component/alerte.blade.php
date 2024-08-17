<section id="alert" class="relative mb-16">
    <div class="container">
        <div class="flex flex-wrap">
            <div class="lg:w-1/3 w-full lg:my-0 my-4">
                <img src="assets/img/bell.png" alt="" class="bg-consultant-rouge lg:mx-0 mx-auto rounded-full px-12 py-1">
            </div>
            <div class="lg:w-2/3 w-full lg:my-0 my-4 lg:border-l-2 border-consultant-rouge lg:px-6">
                <h4 class="text-consultant-rouge lg:text-2xl text-lg font-medium mb-2">
                    Alerte
                </h4>
                <p class="lg:text-lg text-sm text-justify mb-2">
                    Créer vos alertes pour recevoir les appels à concurrence publics qui vous intêressent.
                </p>
                <a href="{{ route('alerte.page') }}">
                    <button class="inline-block text-white bg-consultant-rouge lg:px-4 lg:py-6 px-2 py-4 rounded-lg font-medium lg:text-2xl text-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Créer une alerte
                    </button>
                </a>

                <!-- Modal -->
                <!--div class="modal fade fixed top-0 left-0 hidden w-full h-full bg-black bg-opacity-50 outline-none overflow-x-hidden overflow-y-auto" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog relative w-auto pointer-events-none max-w-[60%]">
                        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                            <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Créer une alerte</h5>
                                <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close">

                                </button>
                            </div>
                            <div class="modal-body relative p-4 bg-consultant-rouge text-white ">
                                <div class="flex  lg:flex-row flex-col">
                                    <div class="lg:w-1/2 w-full">
                                        <h1 class="w-full text-center ">Gratuit</h1>
                                        <div class="w-full">
                                            <ul>
                                                <li>Vous pouvez choisir une seule catégorie</li>
                                                <li>Vous pouvez choisir plusieurs autorités</li>
                                                <li>Un deux trosi</li>
                                            </ul>
                                        </div>
                                        <form action="{{ route('alerte.subscription', 'gratuit' ) }}" method="post" >
                                            @csrf

                                            <div class="w-full text-center">
                                                <button class="lg:text-2xl text-lg text-white font-semibold bg-consultant-blue rounded-lg px-16 py-3">
                                                   Gratuit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="lg:w-1/2 w-full lg:border-l-2 border-white">
                                        <h2 class="w-full text-center ">Gratuit</h2>
                                        <div class="w-full">
                                            <ul class="px-3" >
                                                <li>Choisissez les catégories dont vous voulez les appels </li>
                                                <li>Choissiez les types de domaine qui vous interessent</li>
                                                <li>Soyez informer des formations à chaque publication</li>
                                                <li>Recevz ces notifications par mail </li>
                                            </ul>
                                        </div>
                                        <form action="{{ route('alerte.subscription', 'payant' ) }}" method="post" >
                                            @csrf

                                            <div class="w-full text-center">
                                                <button class="lg:text-2xl text-lg text-white font-semibold bg-consultant-blue rounded-lg px-16 py-3">
                                                    Payer
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                <button type="button" class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">
                                   Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div-->
            </div>
        </div>
    </div>
</section>
