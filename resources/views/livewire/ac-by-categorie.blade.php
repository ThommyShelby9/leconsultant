<div class="form-row">
    <div class="col-sm-12  col-md-4">
        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select id="categorie" name="categorie" class="form-control" wire:model="selectCateg">

                <option value="">Choisir</option>

                @foreach ($les_categories as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach

            </select>
            @error('categorie')
            <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="col-sm-12  col-md-4">
        <label for="categorie">Les A.C</label>
        <select name="autorite" id="autorite" class="form-control" wire:model="selectAc" >

            @if( !is_null($les_ac))

                <option value="">Choisir</option>
                @foreach ($les_ac as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            @else
            <option value="">Choisir d'abord Categorie</option>
            @endif

        </select>

        @error('autorite')
        <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>


    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="service">Service</label>
            <select name="service" id="service" class="form-control"  >
                @if( !is_null($les_directions))

                    <option value="Toutes les directions">Toutes les directions</option>
                    @foreach ($les_directions as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                @else
                    <option value="0">Choisir d'abord A.C</option>
                @endif
            </select>
            @error('service')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>



</div>
