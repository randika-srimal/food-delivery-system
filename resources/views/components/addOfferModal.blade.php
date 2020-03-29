<div class="modal fade" id="add-pack-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Offer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if(Auth::guest())
                <div class="text-center">
                    <p>Please login with Facebook.</p>
                    <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary"><i
                            class="fa fa-facebook"></i> Facebook Login</a>
                </div>
                @else
                <form method="POST" id="save-flyer-form" action="{{ route('offers.saveOffer') }}">
                    @csrf
                    <div class="file-loading">
                        <input type="file" accept="image/*" id="file" data-upload-url="{{route('offers.saveOfferImage')}}">
                    </div>
                    <input required type="hidden" id="flyer-file-name" name="flyer_file_name">
                    <br />
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Category :</label>
                        <br />
                        <input required type="number" name="sub_category_id">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Delivery Areas :</label>
                        <br />
                        <input required type="text" id="delivery-areas" name="areas">
                    </div>
                    <div class="form-group">
                        <label>Details :</label>
                        <textarea class="form-control" name="details"
                            placeholder="Price, Contact Details, etc"></textarea>
                    </div>
                    <button type="button" id="submit-flyer-btn" class="btn btn-primary btn-block">Submit</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
