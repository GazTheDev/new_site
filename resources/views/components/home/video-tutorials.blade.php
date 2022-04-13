<!-- ====== Cards Section Start -->
<section id="videos" class="dark:bg-slate-800 pt-24 pb-16">
  <div class="container">
    <div class="flex flex-wrap -mx-4">
      <div class="w-full px-4">
        <div class="text-center mx-auto mb-[60px] max-w-[510px]">
          <h2 class="font-bold text-3xl text-dark dark:text-gray-300 mb-4">
            Drone Videos
          </h2>
          <p class="text-base text-body-color">
            Below are some videos of my recent drone adventures.
          </p>
        </div>
      </div>
    </div>
    <div class="flex flex-wrap -mx-4">
      @foreach($videoTutorials as $video)
        <x-video-tutorial-item :video-id="$video['videoId']" :title="$video['title']"
                               :description="$video['description']"></x-video-tutorial-item>
      @endforeach
    </div>
    <div class="flex justify-center">
      <x-button-link href="https://www.youtube.com/channel/UCw6rm4CfwOT9wt6CCH1xJUg" target="_blank" class="rounded-lg">
        View All Videos
      </x-button-link>
    </div>
  </div>
</section>
<!-- ====== Cards Section End -->
