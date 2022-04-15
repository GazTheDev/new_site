          <template>
    <section>
       
        <div v-if="isReady" class="mt-5">
            <div class="container mx-auto mx-auto">
                 <h1
            class="text-black dark:text-gray-200 font-bold text-4xl sm:text-[42px] lg:text-[40px] xl:text-[42px] text-lg font-lighting-snug mb-6"
          >
            Welcome To My<br/>
            <span class="rounded-md text-amber-600">Blog</span>.
          </h1>

                <main role="main" class="mt-5">
                    <div>
                        <h4 class="my-4 border-b mt-5 pb-2">
                            <h1 class="border-bottom border-black pb-2">Posts</h1>
                        </h4>

                        <div :key="`${index}-${post.id}`" v-for="(post, index) in posts">
                            <router-link
                                :to="{ name: 'show-post', params: { slug: post.slug } }"
                                class="text-decoration-none"
                            >
                                <div class="relative flex flex-col min-w-0 rounded break-words border bg-blue border-1 border-grey-light mb-4 shadow">
                                    <div class="flex-auto p-6 px-0">
                                        <div class="container lg:inline-flex align-items-center">
                                            <div v-if="post.featured_image" class="w-1/62 lg:w-1/4 pr-4 pl-4 p-0">
                                                <img
                                                    :src="post.featured_image"
                                                    :alt="post.featured_image_caption"
                                                    class="rounded w-full"
                                                />
                                            </div>
                                            <section
                                                class="w-full mt-3 mt-lg-0 px-0 px-lg-3"
                                                :class="post.featured_image ? 'lg:w-3/4 pr-4 pl-4' : ''"
                                            >
                                                <h5 class="mb-3 truncate mb-0">{{ post.title }}</h5>
                                                <p class="mb-0 text-truncate">{{ post.summary }}</p>
                                                <p class="card-text mb-0 text-grey">
                                                    {{ post.user.name }}
                                                    <span v-if="post.topic.length"> in {{ post.topic[0].name }} </span>
                                                </p>
                                                <p class="card-text text-secondary">
                                                    {{ moment(post.published_at).format('MMM D, Y') }} —
                                                    {{ post.read_time }}
                                                </p>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <infinite-loading spinner="spiral" @infinite="fetchPosts">
                            <span slot="no-more" />
                            <div slot="no-results" class="text-left">
                                <div class="my-5">
                                    <p class="lead text-center text-grey mt-5">You have no published posts</p>
                                    <p class="lead text-center text-muted mt-1">
                                        Write on the go with our mobile-ready app!
                                    </p>
                                </div>
                            </div>
                        </infinite-loading>
                    </div>
                </main>
            </div>
        </div>
    </section>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeaderComponent';
import isEmpty from 'lodash/isEmpty';

export default {
    name: 'all-posts',

    components: {
        InfiniteLoading,
        PageHeader,
    },

    metaInfo() {
        return {
            title: 'Blog',
        };
    },

    data() {
        return {
            page: 1,
            posts: [],
            isReady: false,
        };
    },

    async created() {
        await Promise.all([this.fetchPosts()]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchPosts($state) {
            if ($state) {
                return this.request()
                    .get('/api/posts', {
                        params: {
                            page: this.page,
                        },
                    })
                    .then(({ data }) => {
                        if (!isEmpty(data) && !isEmpty(data.data)) {
                            this.page += 1;
                            this.posts.push(...data.data);

                            $state.loaded();
                        } else {
                            $state.complete();
                        }

                        if (isEmpty($state)) {
                            NProgress.inc();
                        }
                    })
                    .catch(() => {
                        NProgress.done();
                    });
            }
        },
    },
};
</script>