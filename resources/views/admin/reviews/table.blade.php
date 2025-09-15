<script type="text/javascript" src="{{ url('assets/js/admin/unflag.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/admin/publish_review.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/login.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/admin/featured_review.js') }}"></script>

@include('login/modal')

<script type="text/javascript">
    $(function(){

        $(window).on('load', function() {
            if($(':checkbox[name="reviews[]"]:checked').length > 0) $('#delete_reviews').prop('disabled', false); 
        });

        $(':checkbox[name="reviews[]"]').change(function(){
            if($(':checkbox[name="reviews[]"]:checked').length > 0) $('#delete_reviews').prop('disabled', false); 
            else $('#delete_reviews').prop('disabled', true);
            if($(this).prop("checked")) $('#review_row'+$(this).val()).addClass('active'); else $('#review_row'+$(this).val()).removeClass('active');
        });
        $(':checkbox[name="select_all_reviews"]').change(function(){
            $(".reviews_checkbox").prop('checked', $(this).prop("checked"));
            $("#delete_reviews").prop('disabled', !$(this).prop("checked"));
            if($(this).prop("checked")) $('.review_row').addClass('active'); else $('.review_row').removeClass('active');
        });
    });//document ready
</script>

<script src="{{ url('assets/js/read_more.js') }}"></script>

<form action="{{ url('admin/reviews/multiple-delete') }}" method="POST">           
    <table class="table">

        @foreach($reviews as $review)
        <tr id="review_row{{$review->id}}" class="review_row @if($review->active == 0) danger @endif">
            <td>
                <div style="margin-bottom: 50px">

                    <div class="item-name">
                            <div class="checkbox">
                                <input type="checkbox" name="reviews[]" class="styled reviews_checkbox" value="{{ $review->id }}" />
                                <label></label>
                                <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug.'?review='.$review->id) }}" target="_blank">{{ $review->product->category->name }} / {{ $review->product->brand->name }} {{ $review->product->name }}</a> 
                                @if($review->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
                                @if($review->featured_on != NULL)<span class="text-muted">(featured)</span>@endif
                            </div>                        
                    </div>
                    
                    <div class="item-name pull-right">
                     <span class="text-muted">
                         <small>
                            <span title="{{ $review->created_at }}">{{ date($settings->date_format,strtotime($review->created_at)) }}</span>
                            by <a href="{{ url('user/'.$review->user_id.'/'.$review->user->username) }}" @include('admin/reviews/username_hover') >{{ $review->user->username }}</a>                            
                        </small>
                    </span>        
                </div>

                <div>
                    @include('admin/reviews/rating')
                </div>

                @if($review->helpful_yes <> 0 || $review->helpful_no <> 0)

                <div class="text-muted">
                    <small>{{ $review->helpful_yes }} of {{ $review->helpful_yes + $review->helpful_no }} people found this review helpful.</small> 
                    <small>Favorited {{ $review->favorites->count() }} times</small>
                </div>

                @else

                <div class="text-muted">
                 <small>favorited {{ $review->favorites->count() }} times</small>
             </div>
             @endif

             @if($review->reported == 1)
             <a href="javascript:unflag_review({{ $review->id }})" class="btn close" id="cross_{{$review->id}}">&times;</a>
             <div id="reported_{{ $review->id }}" class="alert alert-warning alert-block item-name">

                @foreach($review->reports->take(100) as $report)
                <div class="text-muted" style="word-wrap: break-word;">
                <b>Reported by <a href="{{ url('admin/user/'.$report->user_id.'/details') }}">{{ $report->user->username }}</a> </b>
                    <br />
                    @if($report->reason <> ''){!! nl2br($report->reason) !!} @endif
                    <br />
                    <small>{{ $report->created_at }} </small>
                    
                    <br /><br />                    
                </div>
                @endforeach
                
            </div>


            @endif

            @if(!empty($review->title))

            <div class="reviews-table">
                <label>{{ $review->title }}</label>
            </div>

            @endif

            @if(!empty($review->pros))

            <div class="reviews-table">
                <span class="green"><b>Pros:</b></span><span> {{ $review->pros }}</span>
            </div>

            @endif

            @if(!empty($review->cons))

            <div class="reviews-table">
                <span class="red"><b>Cons:</b></span><span> {{ $review->cons }}</span>
            </div>

            @endif

            <div style="padding:0px; margin-top:5px; margin-bottom:5px; word-wrap:break-word;">
                <div id="preview_{{$review->id}}">
                    {!! nl2br(substr($review->text, 0, 100)) !!}@if(strlen($review->text)>100)... <a href="javascript:read_more({{$review->id}})">read more</a>@endif    
                </div>
                @if(strlen($review->text)>100)
                <div id="whole_{{$review->id}}" style="display:none; word-wrap:break-word;">
                    {!! nl2br($review->text) !!}
                </div>
                @endif
            </div>

            <div class="pull-right">
                <a href="{{ url('admin/reviews') }}/{{ $review->id }}/edit" title="Edit" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit silver"></span></a>
                <a id="publish_btn_{{$review->id}}" href="javascript:publish_review({{ $review->id }})" class="btn btn-default btn-xs" title="Click to unpublish"  @if($review->active == 0) style="display:none" @endif><span class="glyphicon glyphicon-ok"></span> Published</a>
                <a id="unpublish_btn_{{$review->id}}" href="javascript:publish_review({{ $review->id }})" class="btn btn-default btn-xs" title="Click to publish" @if($review->active == 1) style="display:none" @endif><span class="glyphicon glyphicon-remove"></span> Unpublished</a>                    

                <a href="javascript:featured_review({{ $review->id }})"><i class="fa fa-star silver" id="star_full_{{ $review->id }}" style="@if($review->featured_on == NULL) display:none @endif" title="Unmark featured"></i><i class="fa fa-star-o silver" id="star_empty_{{ $review->id }}" style="@if($review->featured_on != NULL) display:none @endif" title="Make featured"></i></a>
            </div>

        </div>
    </td>
</tr>
@endforeach

</table>
<div class="form-group">
    {{ csrf_field() }}
    <button type="submit" name="submit_button" id="delete_reviews" value="delete_reviews" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected reviews');" disabled="true">Delete selected</button>
</div>


</form>