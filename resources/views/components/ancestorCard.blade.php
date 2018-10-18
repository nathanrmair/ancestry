@if(!isset($ancestor))
    <?php
    $ancestor = App\Http\Controllers\AncestorController::getAncestor($ancestor_id);
    ?>
@endif
@if(!isset($docs))
    <?php
    $docs = App\Http\Controllers\AncestorController::getAncestorDocuments($ancestor->ancestor_id);
    ?>
@endif
<?php $unknown = "unknown";
$user_id = \App\Ancestor::where('ancestor_id', $ancestor->ancestor_id)->first()->visitor_id?>

<script src="{{ url('/') }}/js/form-mandatory-fields.js"></script>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card">
        <img class="card-img-top"
             @if(isset($ancestor->gender))
             @if($ancestor->gender == 'male')
             src="{{url('/img/male_default_ancestor.png')}}"
             @else
             src="{{url('/img/female_default_ancestor.png')}}"
             @endif
             @else
             src="{{url('/img/male_default_ancestor.png')}}"
             @endif
             alt="Card image cap"/>
        <div class="card-block">
            <h3 class="card-title">{{$ancestor->surname}}, {{$ancestor->forename}}</h3>
            <li class="list-group-item">Date of
                birth:
                <div id="ancestor_dob">@if(isset($ancestor->dob)){{$ancestor->dob}}@else {{$unknown}} @endif</div>
            </li>
            <li class="list-group-item">Date of
                death:
                <div id="ancestor_dod">@if(isset($ancestor->dod)){{$ancestor->dod}}@else {{$unknown}} @endif</div>
            </li>
            <li class="list-group-item">
                Gender: @if(isset($ancestor->gender)){{$ancestor->gender}}@else {{$unknown}} @endif</li>
            <li class="list-group-item">
                Clan: @if(isset($ancestor->clan)){{$ancestor->clan}}@else {{$unknown}} @endif</li>
            <li class="list-group-item">Place of
                Birth: @if(isset($ancestor->place_of_birth)){{$ancestor->place_of_birth}}@else {{$unknown}} @endif</li>
            <li class="list-group-item">Place of
                Death: @if(isset($ancestor->place_of_death)){{$ancestor->place_of_death}}@else {{$unknown}} @endif</li>
            <li class="list-group-item">
                @if(isset($ancestor->description))
                    Description: {{$ancestor->description}}
                @else
                    No description provided
                @endif
            </li>
            </ul>
        </div>
        <div class="card-block">
            <h4 class="card-title">Documents</h4>
            @forelse($docs as $doc)
                <a class="card-files" download="{{$doc['original_filename']}}"
                   href="{{ \App\Http\Controllers\AncestorController::getAncestorDocumentBase64($doc['document_id'],$doc['ancestor_id'],$user_id) }}"
                >
                    <b>{{$doc['original_filename']}}</b>
                </a>
            @empty
                <span class="card-files">No documents provided</span>
            @endforelse
        </div>

        @if(isset($edit_id) && $edit_id == $ancestor->visitor_id)
            <div class="card-block">
                <form action="{{ url('/') }}/ancestor/edit/{{$ancestor->ancestor_id}}">
                    <input class=" btn btn-primary btn-lg " type="submit" value="Edit">
                </form>
            </div>
        @endif
    </div>
</div>

