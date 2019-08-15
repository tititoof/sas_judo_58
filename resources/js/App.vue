<template>
    <div class="layout-demo-3-vue">
        <Layout :siderCollapsed="siderCollapsed">
            <Layout :headerFixed="headerFixed">
                <HHeader theme="white">
                    <Row :space-x="10" type="flex" v-height="50" align="middle" justify="space-around">
                        <Cell width="2">
                            <Slide>
                                <template v-for="menu in menuDatas">
                                    <a :id="menu.key" href="#" @click="handleMenu(menu)" :key="menu.key">
                                        <span> <i :class="menu.icon"></i>&nbsp;&nbsp; {{ menu.title }}</span>
                                    </a>
                                </template>
                            </Slide>
                        </Cell>
                        <Cell width="2">
                            <a href="https://judo-sas.fr/" target="_blank">
                                <img :src="src" style="width: 2em"/>
                            </a>
                        </Cell>
                        <Cell width="12">
                            <a href="">
                                <h1 style="font-size: 1.2em" class="text-center">SAS Judo Jujitsu</h1>
                            </a>
                        </Cell>
                        <Cell width="2">
                            <a href="https://cdjudo37.sportsregions.fr/" target="_blank">
                                <img :src="scrcdp37" style="width: 2em"/>
                            </a>
                        </Cell>
                        <Cell width="2">
                            <a href="https://www.ffjudo.com/" target="_blank">
                                <img :src="srcffjda" style="width: 2em"/>
                            </a>
                        </Cell>
                    </Row>
                </HHeader>
                <Content style="padding: 0px 30px">
                    <router-view></router-view>
                </Content>
                <HFooter class="text-center">
                    Copyright © 2019 <a href="https://github.com/tititoof/sas_judo_58" target="_blank">Christophe Hartmann</a>
                </HFooter>
            </Layout>
        </Layout>
    </div>
</template>

<script>
import Fa from 'vue-fa'
import { Slide } from 'vue-burger-menu' 

export default {
    data() {
        return {
            headerFixed: true,
            siderFixed: true,
            siderCollapsed: false,
            sizeWindow: '1',
            menuDatas: [
                { title: 'Les news', key: 'news', icon: 'h-icon-home' },
                { title: 'Le bureau', key: 'bureau', icon: 'h-icon-users' },
                { title: 'les bons moments', key: 'bons-moments', icon: 'h-icon-message' },
                { title: 'Cotisations', key: 'cotisation', icon: 'h-icon-task' },
                { title: 'Résultats', key: 'resultats', icon: 'h-icon-star' },
                { title: 'Historique', key: 'historique', icon: 'h-icon-refresh' },
                { title: 'Planning des cours', key: 'planning', icon: 'h-icon-calendar' },
                { title: 'Contact', key: 'contact', icon: 'h-icon-location' },
                { title: 'Administration', key: 'administration', icon: 'h-icon-user' }
            ],
            datas: [
                { icon: 'h-icon-home' },
                {
                    title: 'Component',
                    icon: 'h-icon-complete',
                    route: { name: 'Component' }
                },
                { title: 'Breadcrumb', icon: 'h-icon-star' }
            ],
            window: {
                width: 0,
                height: 0
            },
            src: 'images/logo/logo_judo.jpg',
            scrcdp37: 'images/logo/logo_cdp37.jpg',
            srcffjda: 'images/logo/logo_ffjda.png',
        }
    },
    components: {
        Fa, Slide
    },
    methods: {
        handleMenu(menu) {
            this.$router.push('/' + menu.key)
            this.handleToggleDrawer()
        },
        handleResize() {
            this.$store.dispatch('user/setWindowHeight', window.innerHeight)
            this.$store.dispatch('user/setWindowWidth', window.innerWidth)
        },
        handleToggleDrawer() {
            this.$refs.drawerLayout.toggle();
        }
    },
    created() {
        window.addEventListener('resize', this.handleResize)
        this.handleResize()
        this.$router.push('/news')
    },
    destroyed() {
        window.removeEventListener('resize', this.handleResize)
    },
}
</script>

<style lang="less">
.layout-demo-3-vue {
    .h-layout {
        background: #f0f2f5;
    }

    .layout-logo {
        height: 34px;
        background: rgba(255, 255, 255, 0.2);
        margin: 16px 24px;
    }

    .layout-logo-sas {
        height: 34px;
        background: rgba(255, 255, 255, 0.2);
        margin: 16px 24px;
    }

    .h-layout-footer {
        padding: 24px 50px;
        color: rgba(0, 0, 0, 0.65);
        font-size: 14px;
    }

}
.h-layout.h-layout-sider-collapsed {
    .h-layout-sider {
        width: 2em;
        -ms-flex: 0 0 70px;
        flex: 0 0 70px;
        max-width: 70px;
        min-width: 70px;
        overflow: initial;
        z-index: 2;
    }
} 

.bm-burger-button {
    position: fixed;
    width: 1em;
    height: 1em;
    left: 1em;
    top: 1em;
    cursor: pointer;
}
.bm-burger-bars {
    background-color: #418625;
}
.line-style {
    position: absolute;
    height: 20%;
    left: 0;
    right: 0;
}
.cross-style {
    position: absolute;
    top: 12px;
    right: 2px;
    cursor: pointer;
}
.bm-cross {
    background: #bdc3c7;
}
.bm-cross-button {
    height: 24px;
    width: 24px;
}
.bm-menu {
    height: 100%; /* 100% Full-height */
    width: 0; /* 0 width - change this with JavaScript */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Stay on top */
    top: 0;
    left: 0;
    background-color: #418625; /* Black*/
    overflow-x: hidden; /* Disable horizontal scroll */
    padding-top: 60px; /* Place content 60px from the top */
    transition: 0.5s; /*0.5 second transition effect to slide in the sidenav*/
}

.bm-overlay {
    background: #418625;
}
.bm-item-list {
    color: #b8b7ad;
    margin-left: 10%;
    font-size: 1em;
}
.bm-item-list > * {
    display: flex;
    text-decoration: none;
    padding: 0.02em;
}
.bm-item-list > * > span {
    margin-left: 10px;
    font-weight: 700;
    color: white;
}
</style>