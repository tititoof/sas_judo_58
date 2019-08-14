<template>
    <div class="layout-demo-3-vue">
        <Layout :siderFixed="siderFixed" :siderCollapsed="siderCollapsed">
            <Sider theme="white">
                <Row :space-x="10" type="flex" v-height="50" align="middle" justify="space-around">
                    <Cell :width="6">
                        <img :src="src" style="width: 40px"/>
                    </Cell>
                    <Cell :width="10">
                    <a href="" v-show="!siderCollapsed">
                        <h1 style="font-size: 0.9em"> SAS Judo Jujitsu</h1>
                    </a>
                    </Cell>
                </Row>
                <Menu style="margin-top: 1em;" 
                    className="h-menu-white" 
                    :datas="menuDatas" 
                    :inlineCollapsed="siderCollapsed"
                    @click="handleMenu"
                    ref="menu">
                </Menu>
            </Sider>
            <Layout :headerFixed="headerFixed">
                <HHeader theme="white">
                    <Row :space-x="10" type="flex" v-height="50">
                        <Cell width="8">
                            <Button 
                                icon="h-icon-menu" size="l" noBorder style="font-size: 1em" 
                                @click="siderCollapsed=!siderCollapsed">&nbsp;Menu</Button>
                        </Cell>
                        <Cell width="12">
                            <a href=""  v-show="siderCollapsed">
                                <h1 style="font-size: 1.2em"> SAS Judo Jujitsu</h1>
                            </a>
                        </Cell>
                    </Row>
                </HHeader>
                <Content style="padding: 0px 30px;">
                    <router-view></router-view>
                    <HFooter class="text-center">
                        Copyright © 2019 <a href="http://www.ch-un.com" target="_blank">Lan</a>
                    </HFooter>
                </Content>
            </Layout>
        </Layout>
    </div>
</template>

<script>
import Fa from 'vue-fa'

export default {
    data() {
        return {
            headerFixed: true,
            siderFixed: true,
            siderCollapsed: true,
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
            src: 'logo_judo.jpg'
        }
    },
    components: {
        Fa
    },
    methods: {
        handleMenu(menu) {
            this.$router.push('/' + menu.key)
            console.log(menu)
        },
        handleResize() {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
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
    mounted() {
        this.$refs.menu.select('news');
    }
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
</style>