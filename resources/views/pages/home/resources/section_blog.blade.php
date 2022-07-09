@if (!$data->isEmpty())
    <div class="section section-blog">
        <div class="content-ld distance-top">
            <div class="grid grid-cols-12">
                <div class="col-span-5 mt-[54px]">
                    <div class="col-left-description">
                        <h2>Blog</h2>
                        <p>We envision a technologically eloquent world fabricated using our<br>practical SaaS solutions
                            that redefine business propagation.</p>
                    </div>
                </div>
                <div class="col-span-7 col-right-blog">
                    <div class="content-right-blog">
                        <div class="group-blog">
                            @foreach ($data as $item)
                                <div class="item-blog">
                                    <div class="img-blog"><img src="{{ $appUrl . $item->images }}"
                                            alt="{{ $item->name }}"></div>
                                    <div class="content-blog">
                                        <div class="date">{{ $item->created_at }}</div>
                                        <div class="title-4 pt-6 pb-6"><a href="#">{{ $item->name }}</a></div>
                                        <p>{{ $item->meta_desc }}</p>
                                        <div class="pt-6"><a href="#" class="btn-read">Read it <i
                                                    class="fa-regular fa-arrow-up-right"></i></a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
