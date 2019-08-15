<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 380px;">
        <Carousel :datas="carousel" :height="300" pageTheme="circle"></Carousel>
        <h2>Les news</h2>

        <div class="skeleton-demo-3-vue">
            <div class="h-list">
                <div class="h-list-item" v-for="(item, index) in articles" :key="index">
                    <div class="demo-box">
                        <Skeleton active :loading="loading">
                            <div class="h-list-item-meta">
                                
                                <Row :space="10">
                                  <Cell :width="4">
                                    <show-at breakpoint="mediumAndBelow">
                                      <Avatar :src="item.image" shape="square" :width="75" v-width="250" :imageTop="5" fit="fill">
                                        <div style="font-size: 18px;">{{ item.name }}</div>
                                        <p class="dark2-color"></p>
                                        <p class="dark2-color"></p>
                                      </Avatar>
                                    </show-at>
                                    <show-at breakpoint="large">
                                      <Avatar :src="item.image" shape="square" :width="75" v-width="450" :imageTop="5" fit="fill">
                                        <div style="font-size: 18px;">{{ item.name }}</div>
                                        <p class="dark2-color"></p>
                                        <p class="dark2-color"></p>
                                      </Avatar>
                                    </show-at>
                                  </Cell>
                                </Row>
                                <Row :space="9">
                                  <div class="h-list-item-desc" v-html="item.content"></div>
                                </Row>
                                <Row :space="9">
                                  <ImagePreview :datas="pictures[index]" @click="openPreview" />
                                </Row>
                            </div>
                        </Skeleton>
                    </div>
                </div>
                <mugen-scroll :handler="get" :should-handle="!loading">
                </mugen-scroll>
            </div>
        </div>
    </div>
</template>

<script>
import MugenScroll from 'vue-mugen-scroll'
import {showAt, hideAt} from 'vue-breakpoints'
export default {
  data() {
    return {
        articles: [],
        pictures: [],
        nbArticles: 0,
        nbPerPage: 5,
        nbTotalArticles: 0,
        menu: 1,
        page: 0,
        loading: false,
        listeImages: [
            'images/news/1.jpg', 'images/news/2.jpg', 'images/news/3.gif', 'images/news/4.gif',
            'images/news/5.gif', 'images/news/6.jpg', 'images/news/7.gif', 'images/news/8.jpg',
            'images/news/9.gif', 'images/news/10.gif'
        ],
        carousel: [
          
        ]
    };
  },
  computed: {
    
  },
  components: { MugenScroll, hideAt, showAt},
  methods: {
    setImages() {
        const _self = this;
        _self.articles.forEach((article, index) => {
        if (!_self.pictures.hasOwnProperty(index)) {
            _self.pictures[index] = [];
        }
        article.albums.forEach(album => {
            album.pictures.forEach(picture => {
            let tempo_picture = {
                thumbUrl: "/get/picture/" + picture.id + "",
                url: "/get/picture/" + picture.id + "/false"
            }
            _self.pictures[index].push(tempo_picture);
            })
        });
      });
    },
    randomImage() {
      const _self = this
      let imagesLength = _self.listeImages.length
      let randomNumber = Math.floor(Math.random() * Math.floor(imagesLength));
      return _self.listeImages[randomNumber]
    },
    openPreview(index = 0, data) {
        this.$ImagePreview(this.datas, index);
    },
    get() {
        const _self = this;
        _self.page += 1
        if ( (_self.articles.length === 0) || (_self.articles.length < _self.nbTotalArticles) ) {
            _self.$http.get("api/visitor/menu/1/" + _self.page).then(response => {
                let list_articles = response.data.data.articles
                for (let article in list_articles) {
                    list_articles[article].image = _self.randomImage()
                    _self.articles.push(list_articles[article])
                }
                _self.nbArticles = _self.articles.length
                _self.nbTotalArticles = response.data.data.nbArticles
                _self.setImages()
                
                _self.loading = false
            })
        }
        
    }
  },
  mounted() {
    const _self = this
    _self.$http.get('api/visitor/carousel').then( response => {
      console.log(response)
      response.data.data.forEach( (picture) => {
        _self.carousel.push({ image: '/get/picture/' + picture.id + '/false'})
      })
      
    })
  }
};
</script>

<style lang='less'>
.skeleton-demo-3-vue {
  .h-list {
    .h-list-item {
      padding: 16px 0;
      &:not(:last-child) {
        border-bottom: 1px solid #e8e8e8;
      }
      .h-list-item-meta {
        margin-bottom: 16px;
      }
      .h-list-item-title {
        margin-bottom: 12px;
        color: rgba(0, 0, 0, 0.85);
        font-size: 16px;
        line-height: 24px;
      }
      .h-list-item-desc {
        color: rgba(0, 0, 0, 0.45);
        font-size: 14px;
        line-height: 22px;
      }
    }
  }
}
.demo-box {
  padding: 16px 0;
  &:not(:last-child) {
    border-bottom: 1px solid #e8e8e8;
  }
  .h-list-item-meta {
    margin-bottom: 16px;
    margin-left: 16px;
  }
  .h-list-item-title {
    margin-bottom: 12px;
    color: rgba(0, 0, 0, 0.85);
    font-size: 16px;
    line-height: 24px;
  }
  .h-list-item-desc {
    color: rgba(0, 0, 0, 0.45);
    font-size: 14px;
    line-height: 22px;
  }
}
.h-avatar-image-container .h-avatar-image {
    position: absolute;
    z-index: 1;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    height: 70px;
    width: 100%;
}
</style>