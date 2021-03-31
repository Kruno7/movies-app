<template>
    <div>
        <div>
            <h2 v-if="user" style="text-align:center">Welcome: {{ user.name }} </h2>
        </div>
        <div class="content">
            <div class="title">   
                <h3>Search By Title</h3>
                <hr>
                <form class="row">
                    <div class="col-md-4">
                        <label for="title">Title</label><br>
                        <input type="text" v-model="title" id="title" autocomplete="off" />
                    </div>
                    <div class="col-md-2">
                        <label for="year">Year</label><br>
                        <input type="number" v-model="year" id="year" />
                    </div>
                    <div class="col-md-2">
                        <label for="response">Response</label><br>
                        <input type="text" id="response" disabled value="JSON" />
                    </div>
                    <div class="col-md-1"><br>
                        <input type="submit" @click.prevent="searchMovieByTitle" class="inp-search" value="Search">
                        <input type="reset" @click="reset" class="inp-reset" value="Reset">
                    </div>
                </form>
                <div v-if="show" class="show">
                    <div v-if="user">
                        Request : <a v-if="url" v-bind:href="url" target="_blank"> {{ url }} </a>
                    </div>
                    <h5 v-else>If you want use API please log in </h5>
                    Response : {{ movie }}
                </div>
            </div>
           
            <div class="search-id">   
                <h3>Search By ID</h3>
                <hr>
                <form class="row">
                    <div class="col-md-4">
                        <label for="imdbid">ID</label><br>
                        <input type="text" v-model="imdbid" id="imdbid" placeholder="imdb ID" autocomplete="off" />
                    </div>
                    
                    <div class="col-md-2">
                        <label for="response">Response</label><br>
                        <input type="text" id="response" disabled value="JSON" />
                    </div>
                    <div class="col-md-1"><br>
                        <input type="submit" class="inp-search" @click.prevent="searchMovieById" value="Search">
                        <input type="reset" @click="reset" class="inp-reset" value="Reset">
                    </div>
                </form>
                <div v-if="show_id" class="show-id">
                    <div v-if="user">
                        Request : <a v-if="url_id" v-bind:href="url_id" target="_blank"> {{ url_id }} </a>
                    </div>
                    <h5 v-else>If you want use API please log in </h5>
                    Response : {{ movie_id }}
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import { mapGetters } from 'vuex'
import axios from 'axios'
export default {
    name: 'Search',
    data () {
        return {
            title: '',
            year: '',
            show: false,
            show_id: false,
            movie: '',
            movie_id: '',
            imdbid: '',
            url: '',
            url_id: '',
        }
    },
    methods: {
        searchMovieByTitle () {
            axios.get(`api/movie?title=${this.title}&year=${this.year}`)
               .then(res => {
                   if (this.year > 0) {
                        this.url = 'http://localhost/' + res.config.url
                   } else {
                       var pathArray = res.config.url.split('&')[0]
                       this.url = 'http://localhost/' + pathArray
                   }
                   
                   if (res.data) {
                       this.show  = true
                       this.movie = res.data
                   } else {
                       if (this.title && !this.year) {
                           axios.get(`https://www.omdbapi.com/?t=${this.title}&apikey=c9b319c4`)
                            .then(res => {
                                this.show = !this.show
                                this.movie = res.data
                                let dataToLowerCase = Object.keys(res.data)
                                .reduce((destination, key) => {
                                    destination[key.toLowerCase()] = res.data[key];
                                    return destination;
                                }, {});
                                
                                axios.post('/api/movie', {
                                    dataMovie: dataToLowerCase
                                })
                                .then((res) => {
                                    console.log(res.data)
                                })
                                .catch(err => {
                                    console.log(err)
                                })
                            })

                       } else if (this.title && this.year) {
                           axios.get(`https://www.omdbapi.com/?t=${this.title}&y=${this.year}&apikey=c9b319c4`)
                            .then(res => {
                                this.show = true
                                this.movie = res.data
                                let dataToLowerCase = Object.keys(res.data)
                                .reduce((destination, key) => {
                                    destination[key.toLowerCase()] = res.data[key];
                                    return destination;
                                }, {});
                                
                                axios.post('/api/movie', {
                                    dataMovie: dataToLowerCase
                                })
                                .then(res => {
                                    console.log(res.data)
                                })
                                .catch(err => {
                                    console.log(err)
                                })
                            })
                       }
                   }
               }).catch(err => console.log(err))
        },
        searchMovieById () {
            axios.get(`api/movie-id?imdbid=${this.imdbid}`)
            .then(res => {
                if (res.data) {
                    this.movie_id = res.data
                } else {
                    axios.get(`https://www.omdbapi.com/?i=${this.imdbid}&apikey=c9b319c4`)
                    .then(res => {
                        this.movie_id = res.data
                        let dataToLowerCase = Object.keys(res.data)
                        .reduce((destination, key) => {
                            destination[key.toLowerCase()] = res.data[key];
                            return destination;
                        }, {});
                        axios.post('api/movie-id', {
                            dataMovie: dataToLowerCase
                        })
                        .then(res => {
                            console.log(res.data)
                        })
                        .catch(err => {
                            console.log(err)
                        })
                    })
                }
                this.url_id = 'http://localhost/' + res.config.url
                this.show_id = true
            })
        },

        reset () {
            this.show     = false
            this.show_id  = false
            this.title = ''
            this.year  = ''
            this.imdbid = ''
        },

    },
   
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
    },
    
}
</script>

<style scoped>
    
    .content {
        width: 60%;
        margin: auto;
    }
    .row {
        display: flex;
    }
    .row div {
        margin: 10px;
    }
    .row div {
        flex-grow: 1;
        flex-basis: 0;
    }
    input {
        padding: 7px;
    }
    .show {
        margin: 10px;
        background-color: #43ac6a;
        color: #fff;
        word-wrap:break-word;
    }
    .show-id {
        margin: 10px;
        background-color: #43ac6a;
        color: #fff;
        word-wrap:break-word;
    }
    .search-id {
        margin-top: 30px;
    }

    .inp-search {
        background-color: rgb(119, 155, 175);
        color: #fff;
        border: 2px solid rgb(119, 155, 175);
    }
    
    .inp-search:hover {
        background-color: rgb(160, 185, 199);
        cursor: pointer;
    }

    .inp-reset:hover {
        cursor: pointer;
    }
</style>