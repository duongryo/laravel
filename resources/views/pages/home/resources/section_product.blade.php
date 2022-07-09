@if (!$data->isEmpty())
    <div class="section section-product">
        <div class="content-ld distance-top">
            <div class="grid grid-cols-12">
                <div class="col-span-5 mt-[54px]">
                    <div class="col-left-description">
                        <h2 class="text">Our products</h2>
                        <p class="text">Volutpat amet curabitur ipsum, elementum facilisis nunc eu.</p>
                        <p class="text">Praesent diam aenean aenean tempor arcu enim.</p>
                        <div class="mt-[69px]"><a class="btn-view" href="#">Work with Us <i
                                    class="fa-light fa-arrow-right-long"></i></a></div>
                    </div>
                </div>
                <div class="col-span-7 col-right-product">
                    <div class="content-right-product">
                        @foreach ($data as $item)
                            <div class="item-product">
                                <div class="grid grid-cols-11">
                                    <div class="col-span-4 col-r-1">
                                        <div class="title-tag">{{ $item->label }}</div>
                                        <img class="logo-p" src="{{ $appUrl . $item->logo }}"
                                            alt="{{ $item->name }}">
                                        <p>
                                            {{ $item->description }}
                                        </p>
                                        <div class="mt-[126px]">
                                            <a href="{{ $item->link }}" target="_blank" class="btn-visit">Visit link
                                                <i class="fa-regular fa-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-span-7 col-r-2">
                                        <div class="image-product">
                                            <img src="{{ $appUrl . $item->images }}" alt="{{ $item->name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="box-bottom-product">
                        <div class="h-12"></div>
                        <div class="grid grid-cols-2 container-pagination">
                            <div class="group-icon">
                                @foreach ($data as $key => $item)
                                    <p class="slide-item-{{ $key }} {{ $key == 0 ? 'active' : '' }}"></p>
                                @endforeach
                            </div>
                            <div class="pre-next">
                                <p class="pre"><a href="#"><i class="fa-light fa-arrow-left-long"></i>
                                        PREVIOUS</a></p>
                                <p class="next"><a href="#">NEXT <i
                                            class="fa-light fa-arrow-right-long"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
