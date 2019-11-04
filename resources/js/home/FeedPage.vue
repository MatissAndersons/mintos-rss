<template>
    <div>
        <h1 class="text-center mb-5">Today's summary of TheRegistar.co.uk:</h1>
        <em v-if="feed.loading">Loading feed...</em>
        <h2 class="mb-3">Most commonly used words today with their respective counts:</h2>
        <ul v-if="feed.counts" class="row">
            <li v-for="(count, index) in feed.counts" :key="index" class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <h3 class="font-italic text-secondary">{{ count.word }}</h3>
                <div class="description">{{ count.count }}</div>
            </li>
        </ul>

        <h2 class="mb-3">Latest entries</h2>
        <span v-if="feed.error" class="text-danger">ERROR: {{feed.error}}</span>
        <ul v-if="feed.entries">
            <li v-for="entry in feed.entries" :key="entry.index" class="mb-4">
                <a :href="entry.link" target="_blank" class="post-link text-dark">
                    <h3 class="title font-italic">{{ entry.title }}</h3>
                    <div class="description" v-html="entry.description"></div>
                </a>
            </li>
        </ul>
        <p>
            <router-link to="/login">Logout</router-link>
        </p>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        computed: {
            ...mapState({
                account: state => state.account,
                feed: state => state.feeds.all
            })
        },

        created () {
            this.getFeed();
        },

        methods: {
            ...mapActions('feeds', {
                getFeed: 'getFeed'
            })
        }
    };
</script>

<style>
    a.post-link {
        text-decoration: none;
    }

    .title {
        color: #6c757d;
    }

    a.post-link:hover .title {
        text-decoration: underline;
        color: #007bff;
    }
</style>
