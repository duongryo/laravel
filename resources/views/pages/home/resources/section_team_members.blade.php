@if (!$data->isEmpty())
    <div class="section section-team-members">
        <div class="content-ld distance-top">
            <div class="grid grid-cols-12">
                <div class="col-span-5 mt-[54px]">
                    <div class="col-left-description">
                        <h2>Team members</h2>
                        <p>We envision a technologically eloquent world fabricated using our <br>practical SaaS
                            solutions that redefine business propagation.</p>
                        <div class="mt-[69px]"><a class="btn-view" href="#">Join with Us <i
                                    class="fa-light fa-arrow-right-long"></i></a></div>
                    </div>
                </div>
                <div class="col-span-7 col-right-members">
                    <div class="content-members">
                        @foreach ($data as $item)
                            <div class="item-member">
                                <img src="{{ $appUrl . $item->images }}" alt="{{ $item->name }}">
                                <div class="box-item-member">
                                    <div class="regency">
                                        <p>{{ $item->position }}</p>
                                    </div>
                                    <div class="title-member">{{ $item->name }}</div>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
