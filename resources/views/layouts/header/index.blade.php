<div id="Header_wrapper" class="">
  
   <header class="mhb-grid" data-desktop="custom custom" data-tablet="auto auto" data-mobile="custom off">
       <div class="mhb-placeholder"></div>
       <div class="mhb-view desktop default wrap_into_grid">
           <div class="mhb-row action-bar">
               <div class="mhb-row-wrapper container">
                   <div class="mhb-col left"></div>
                   <div class="mhb-col center"></div>
                   <div class="mhb-col right">
                       <div class="mhb-item mhb-social mhb-custom-xOlw7-4HW">
                           <ul>
                               <li><a href="#"><i class="icon-facebook-circled"></i></a></li>
                               <li><a href="#"><i class="icon-globe-line"></i></a></li>
                               <li><a href="#"><i class="icon-gplus"></i></a></li>
                               <li><a href="#"><i class="icon-linkedin-circled"></i></a></li>
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
           <div class="mhb-row first-row">
               <div class="mhb-row-wrapper container">
                   <div class="mhb-col left">
                       <div class="mhb-item mhb-logo mhb-custom-cNBnVpUvb">
                           <div class="mhb-item-inner "><a href="{{route('home')}}"
                                   title="Khinh Khí Cầu"><img class="logo"
                                       src="{{$setting->logo}}"
                                       data-retina="{{$setting->logo}}"
                                       height="75" style="height:75px" /></a></div>
                       </div>
                   </div>
                   <div class="mhb-col center">
                       <div class="mhb-item mhb-menu mhb-custom-H8AwjdAcq">
                           <div class="mhb-item-inner tabletMobile">
                               <ul id="menu-menu-left" class="menu">
                                   <li id="menu-item-98"
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-10 current_page_item menu-item-98">
                                       <a href="{{route('home')}}" aria-current="page"><span>Trang
                                               chủ</span></a></li>
                                   <li id="menu-item-97"
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-97">
                                       <a href="{{route('aboutUs')}}"><span>Giới
                                               thiệu</span></a></li>
                                    
                                   <li id="menu-item-95"
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-95">
                                       <a href="{{ route('eventList') }}"><span>Sự kiện</span></a>
                                   </li>
                                   @foreach ($blogCate as $item)
                                   <li id="menu-item-96"
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-96">
                                       <a href="{{route('listCateBlog',['slug' => $item->slug])}}"><span>{{languageName($item->name)}}</span></a>
                                   </li>
                                   @endforeach
                                   <li id="menu-item-94"
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94">
                                       <a href="{{route('lienHe')}}"><span>Liên hệ</span></a>
                                   </li>
                               </ul><a class="mobile-menu-toggle" href="#"><i class="icon-menu-fine"></i></a>
                           </div>
                       </div>
                   </div>
                   <div class="mhb-col right">
                       <div class="mhb-item mhb-button mhb-custom-1bt-mJHZd"><a class="action_button "
                               href="tel:{{$setting->phone1}}">Hotline: {{$setting->phone1}}</a></div>
                   </div>
               </div>
           </div>
       </div>
       <div class="mhb-view desktop sticky wrap_into_grid">
           <div class="mhb-row action-bar">
               <div class="mhb-row-wrapper container">
                   <div class="mhb-col left"></div>
                   <div class="mhb-col center"></div>
                   <div class="mhb-col right">
                       <div class="mhb-item mhb-social mhb-custom-8pl0W5se2">
                           <ul>
                               <li><a href="#"><i class="icon-facebook-circled"></i></a></li>
                               <li><a href="#"><i class="icon-globe-line"></i></a></li>
                               <li><a href="#"><i class="icon-gplus"></i></a></li>
                               <li><a href="#"><i class="icon-linkedin-circled"></i></a></li>
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
           <div class="mhb-row first-row">
               <div class="mhb-row-wrapper container">
                   <div class="mhb-col left">
                       <div class="mhb-item mhb-logo mhb-custom-ujdomiDfyH">
                           <div class="mhb-item-inner "><a href="{{route('home')}}"
                                   title="Khinh Khí Cầu"><img class="logo"
                                       src="{{$setting->logo}}"
                                       data-retina="{{$setting->logo}}"
                                       height="85" style="height:85px" /></a></div>
                       </div>
                   </div>
                   <div class="mhb-col center">
                       <div class="mhb-item mhb-menu mhb-custom-GJUtNxrhQr">
                           <div class="mhb-item-inner tabletMobile">
                               <ul id="menu-menu-left-1" class="menu">
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-10 current_page_item menu-item-98">
                                       <a href="{{route('home')}}" aria-current="page"><span>Trang
                                               chủ</span></a></li>
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-97">
                                       <a href="{{route('aboutUs')}}"><span>Giới
                                               thiệu</span></a></li>
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-95">
                                       <a href="{{ route('eventList') }}"><span>Sự kiện</span></a>
                                   </li>
                                   @foreach ($blogCate as $item)
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-96">
                                       <a href="{{route('listCateBlog',['slug' => $item->slug])}}"><span>{{languageName($item->name)}}</span></a>
                                   </li>
                                   @endforeach
                                   </li>
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94">
                                       <a href="{{route('lienHe')}}"><span>Liên hệ</span></a>
                                   </li>
                               </ul><a class="mobile-menu-toggle" href="#"><i class="icon-menu-fine"></i></a>
                           </div>
                       </div>
                   </div>
                   <div class="mhb-col right">
                       <div class="mhb-item mhb-button mhb-custom-PNmuSbtrwn"><a class="action_button "
                               href="tel:{{$setting->phone1}}">Hotline: {{$setting->phone1}}</a></div>
                   </div>
               </div>
           </div>
       </div>
       <div class="mhb-view mobile default wrap_into_grid">
           <div class="mhb-row action-bar">
               <div class="mhb-row-wrapper container">
                   <div class="mhb-col left"></div>
                   <div class="mhb-col center">
                       <div class="mhb-item mhb-text mhb-custom-jki6o1Erm">Vươn tầm & Bay xa</div>
                   </div>
                   <div class="mhb-col right"></div>
               </div>
           </div>
           <div class="mhb-row first-row">
               <div class="mhb-row-wrapper container">
                   <div class="mhb-col left">
                       <div class="mhb-item mhb-logo mhb-custom-nP1Mcd6men">
                           <div class="mhb-item-inner "><a href="{{route('home')}}"
                                   title="Khinh Khí Cầu"><img class="logo"
                                       src="{{$setting->logo}}"
                                       data-retina="{{$setting->logo}}"
                                       height="50" style="height:50px" /></a></div>
                       </div>
                   </div>
                   <div class="mhb-col center"></div>
                   <div class="mhb-col right">
                       <div class="mhb-item mhb-menu mhb-custom-7cv-Q8EpOP">
                           <div class="mhb-item-inner tabletMobile">
                               <ul id="menu-menu-left-2" class="menu">
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-10 current_page_item menu-item-98">
                                       <a href="{{route('home')}}" aria-current="page"><span>Trang
                                               chủ</span></a></li>
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-97">
                                       <a href="{{route('aboutUs')}}"><span>Giới
                                               thiệu</span></a></li>
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-95">
                                       <a href="{{ route('eventList') }}"><span>Sự kiện</span></a>
                                   </li>
                                   @foreach ($blogCate as $item)
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-96">
                                       <a href="{{route('listCateBlog',['slug' => $item->slug])}}"><span>{{languageName($item->name)}}</span></a>
                                   </li>
                                   @endforeach
                                   <li
                                       class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94">
                                       <a href="{{route('lienHe')}}"><span>Liên hệ</span></a>
                                   </li>
                               </ul><a class="mobile-menu-toggle" href="#"><i class="icon-menu-fine"></i></a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </header>

</div>
