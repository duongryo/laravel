<!-- Add Modal -->
<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus"></i>Add</button>
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ !empty($route) ? $route : Request::url() }}" id="modal-form-add">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm" id="modal-add-submit">Submit</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.getElementById("modal-add").addEventListener('submit', () => {
        let element = document.getElementById("modal-add-submit");
        element.innerHTML = "Loading";
        element.disabled = true;
    });
</script>