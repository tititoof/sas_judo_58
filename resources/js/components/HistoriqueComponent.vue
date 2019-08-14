<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 380px;">
        <h2>L'historique du club</h2>
        <div class="skeleton-demo-3-vue">
            <div class="h-list">
                <div class="h-list-item" v-for="(item, index) in articles" :key="index">
                    <div class="demo-box">
                        <Skeleton active :loading="loading">
                            <div class="h-list-item-meta">
                                <h4 class="h-list-item-title">{{ item.name }}</h4>
                                <div class="h-list-item-desc" v-html="item.content"></div>
                                <ImagePreview :datas="pictures[index]" @click="openPreview" />
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
    };
  },
  components: {MugenScroll},
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
                thumbUrl: "/get/picture/" + picture.id + "/false",
                url: "/get/picture/" + picture.id + "/false"
            }
            _self.pictures[index].push(tempo_picture);
            })
        });
      });
    },
    openPreview(index = 0, data) {
        this.$ImagePreview(this.datas, index);
    },
    get() {
        const _self = this;
        _self.page += 1
        console.log(_self.articles.length < _self.nbTotalArticles)
        if ( (_self.articles.length === 0) || (_self.articles.length < _self.nbTotalArticles) ) {
            _self.$http.get("api/visitor/menu/8/" + _self.page).then(response => {
                let list_articles = response.data.data.articles
                for (let article in list_articles) {
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
    //this.get()
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
</style>