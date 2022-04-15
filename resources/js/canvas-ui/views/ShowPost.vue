<template>
    <section>
        
  
    

        <div v-if="isReady" class="mt-5">
            <div class="xl:w-2/3 pr-4 pl-4 xl:mx-1/5 lg:w-1/6 pr-4 pl-40 lg:mx-1/6 md:w-1/6 pr-4 pl-42 mt-3">
                <h1 class="text-xl">{{ post.title }}</h1>

                <div class="media pt-1 pb-5">
                   

                    <div class="media-body">
                        <p class="my-0">
                           
                            <span v-if="post.topic.length">
                                in
                                <router-link
                                    :to="{ name: 'show-topic', params: { slug: post.topic[0].slug } }"
                                    class="text-decoration-none"
                                >
                                    {{ post.topic[0].name }}
                                </router-link>
                            </span>
                        </p>
                        <span class="text-grey"
                            >{{ moment(post.published_at).format('MMM D, Y') }} — {{ post.read_time }}</span
                        >
                    </div>
                </div>

                <img
                    v-if="post.featured_image"
                    :src="post.featured_image"
                    class="pt-4 max-w-full h-auto w-full"
                    :alt="post.featured_image_caption"
                    :title="post.featured_image_caption"
                />

                <p
                    v-if="post.featured_image && post.featured_image_caption"
                    class="text-grey text-center featured-image-caption"
                    v-html="post.featured_image_caption"
                />

                <div class="post-content relative align-items-center overflow-y-visible font-serif mt-4">
                    <div v-html="post.body" />
                </div>

                <div v-if="post.tags.length" class="mt-5">
                    <router-link
                        :key="tag.id"
                        v-for="tag in post.tags"
                        :to="{ name: 'show-tag', params: { slug: tag.slug } }"
                        class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-black bg-grey-light p-2 my-1 mr-2 text-decoration-none uppercase"
                    >
                        {{ tag.name }}
                    </router-link>
                </div>

                <div
                    v-if="post.meta.canonical_link"
                    class="post-content position-relative align-items-center overflow-y-visible font-serif"
                >
                    <hr />
                    <p class="text-center italic mb-5">
                        This post was originally published on
                        <a :href="post.meta.canonical_link" target="_blank" rel="noopener">{{
                            parseURL(post.meta.canonical_link).host
                        }}</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeaderComponent';
import hljs from 'highlight.js';
import mediumZoom from 'medium-zoom';

export default {
    name: 'show-post',

    components: {
        PageHeader,
    },

    metaInfo() {
        return {
            title: this.post?.meta?.title,
            meta: [
                { name: 'description', content: this.post?.meta?.description || null },
                { property: 'og:title', content: this.post?.meta?.title || null },
                { property: 'og:image', content: this.post?.featured_image || null },
                { property: 'og:description', content: this.post?.meta?.description || null },
                { name: 'twitter:card', content: 'summary' },
                { name: 'twitter:title', content: this.post?.meta?.title || null },
                { name: 'twitter:description', content: this.post?.meta?.description || null },
                { name: 'twitter:image', content: this.post?.featured_image || null },
            ],
        };
    },

    data() {
        return {
            uri: this.$route.params.slug,
            page: 1,
            post: null,
            isReady: false,
        };
    },

    computed: {
        hasAccess() {
            if (this.CanvasUI.user) {
                return this.CanvasUI.user.id === this.post.user.id || this.isAdmin || this.isEditor;
            } else {
                return false;
            }
        },
    },

    async created() {
        await Promise.all([this.fetchPost()]);

        // Hack since vue-meta doesn't seem to like canonical tags
        if (this.post?.meta?.canonical_link != null) {
            let link = document.createElement('link');
            link.rel = 'canonical';
            link.href = this.post.meta.canonical_link;
            document.head.appendChild(link);
        }

        this.isReady = true;
        NProgress.done();
    },

    updated() {
        document.querySelectorAll('.embedded_image img').forEach((image) => {
            mediumZoom(image);
        });

        document.querySelectorAll('pre').forEach((block) => {
            hljs.highlightBlock(block);
        });
    },

    beforeRouteLeave(to, from, next) {
        // Hack to remove the canonical tag when you navigate away
        document.querySelector('link[rel="canonical"]')?.remove();
        next();
    },

    methods: {
        fetchPost() {
            return this.request()
                .get(`/api/posts/${this.uri}`)
                .then(({ data }) => {
                    this.post = data;
                    NProgress.inc();
                })
                .catch(() => {
                    this.$router.push({ name: 'posts' });
                });
        },
    },
};
</script>
