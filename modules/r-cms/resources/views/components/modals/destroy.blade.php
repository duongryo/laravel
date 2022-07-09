<!-- Destroy Modal -->
<button class="btn btn-danger btn-sm btn-icon" type="button" data-toggle="modal" data-target="#modal-destroy-{{ $id }}">
    <i class="fas fa-trash"></i>
</button>
<div class="modal fade text-left" id="modal-destroy-{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ !empty($route) ? $route : Request::url().'/'.$id }}">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
        </form>
    </div>
</div>