<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 380px;">
        <h2>Le bureau</h2>
        <show-at breakpoint="mediumAndBelow">
            <section>
                <div class="demo-box" v-for="human in listeBureau" :key="human.name">
                    <Avatar :src="human.image" shape="square" :width="100" v-width="300" :imageTop="5" fit="fill">
                        <div style="font-size: 1em;" class="text-ellipsis">
                            <b>{{ human.type }}</b> <br/><i>{{ human.name }}</i>
                        </div>
                        <p class="dark2-color">
                            <Row>
                                <Cell width="2">
                                    <fa :icon="faEnvelope"></fa>
                                </Cell>
                                <Cell width="20" v-html="human.address">
                                </Cell>
                            </Row>
                        </p>
                        <p class="dark2-color">
                            <Row>
                                <Cell width="2">
                                    <fa :icon="faPhone"></fa>
                                </Cell>
                                <Cell width="20" v-html="human.phone">
                                </Cell>
                            </Row>
                        </p>
                        <p class="dark2-color">
                            <Row>
                                <Cell width="2">
                                    <fa :icon="faAt"></fa>
                                </Cell>
                                <Cell width="20" v-html="human.email">
                                </Cell>
                            </Row>
                        </p>
                    </Avatar>
                </div>
            </section>
        </show-at>
        <show-at breakpoint="large">
            <div class="skeleton-demo-3-vue">
                <div class="h-list">
                    <div class="h-list-item" v-for="(item, index) in articles" :key="index">
                        <div class="demo-box">
                            <Skeleton active :loading="loading">
                                <div class="h-list-item-meta">
                                    <h4 class="h-list-item-title">{{ item.name }}</h4>
                                    <div class="h-list-item-desc" v-html="item.content"></div>
                                </div>
                            </Skeleton>
                        </div>
                    </div>
                </div>
            </div>
        </show-at>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Fa             from 'vue-fa'
import { faEnvelope, faPhone, faAt }     from '@fortawesome/free-solid-svg-icons'
import {showAt, hideAt} from 'vue-breakpoints'
export default {
    data() {
        return {
            articles:   [],
            pictures:   [],
            nbArticles: 0,
            nbPerPage:  5,
            menu:       1,
            page:       1,
            loading:    true,
            srcPresidente: 'images/bureau/presidente.gif',
            listeBureau: [
                {
                    type:       'Présidente',
                    name:       'MAINGOURD Patricia',
                    image:      'images/bureau/presidente.gif',
                    address:    '15, Rue A. Bauchant <br/> 37550 SAINT-AVERTIN',
                    phone:      '02.47.27.10.01<br/>06.25.09.19.11',
                    email:      'pmaingourd1@gmail.com',
                },
                {
                    type:       'Secrétaire',
                    name:       'NYSZAK Catherine',
                    image:      'images/bureau/secretaire.gif',
                    address:    '37550 SAINT-AVERTIN',
                    phone:      '06.07.66.74.66',
                    email:      'c.nyszak@orange.fr',
                },
                {
                    type:       'Trésorière',
                    name:       'CHESNAY Françoise',
                    image:      'images/bureau/tresorier.gif',
                    address:    '37200 TOURS',
                    phone:      '06.07.66.74.66',
                    email:      'chesfran37@orange.fr',
                },
                {
                    type:       'Trésorier Adjoint',
                    name:       'TOUCHARD Jean-Michel',
                    image:      'images/bureau/tresorier-1.gif',
                    address:    '37550 SAINT-AVERTIN',
                    phone:      '02.47.28.91.32 <br/>06.78.62.80.86',
                    email:      'jm.touchard@wanadoo.fr',
                },
                {
                    type:       'Trésorier Adjoint',
                    name:       'TYMCZUK Jean-Marc',
                    image:      'images/bureau/tresorier-1.gif',
                    address:    '14, Allée des Jardins <br/>37550 SAINT-AVERTIN',
                    phone:      '02.47.27.77.32 <br/>06.80.45.86.01',
                    email:      'jm.tymczuk@kami.fr',
                },
                {
                    type:       'Correspondant Presse',
                    name:       'JARAUD Francis',
                    image:      'images/bureau/journaux.gif',
                    address:    '28 Rue Toulouse Lautrec <br/>37550 SAINT-AVERTIN',
                    phone:      '02.47.27.99.71 <br/>06.75.16.17.17',
                    email:      'isafran@orange.fr',
                },
                {
                    type:       'Référent site',
                    name:       'HARTMANN Christophe',
                    image:      'images/bureau/informatique.gif',
                    address:    '4 Rue Auguste Fouquet <br/>37550 SAINT-AVERTIN',
                    phone:      '06.65.71.19.75',
                    email:      'chartmann.35@gmail.com',
                },
                {
                    type:       'Membre du bureau',
                    name:       'CHAUVIN Claude',
                    image:      'images/bureau/employe.gif',
                    address:    '19 Rue de la Ricottière <br/>37170 CHAMBRAY LES TOURS',
                    phone:      '02.47.27.96.08<br/>06.09.43.23.35',
                    email:      'claude_cha@yahoo.fr',
                },
                {
                    type:       'Membre du bureau',
                    name:       'MAILLET Alain',
                    image:      'images/bureau/employe.gif',
                    address:    '37550 SAINT-AVERTIN',
                    phone:      '06.66.69.38.71',
                    email:      'maillet.alain@bbox.fr',
                },
                {
                    type:       'Enseignant',
                    name:       'AUGER Pascal',
                    image:      'images/bureau/enseignant.gif',
                    address:    '9 Route de la Bouriolle<br/>37320 ESVRES',
                    phone:      '02.47.26.52.55<br/>06.89.42.22.12',
                    email:      'calou.1963@orange.fr',
                },
                {
                    type:       'Enseignant',
                    name:       'LEBOUCHER Alain',
                    image:      'images/bureau/enseignant.gif',
                    address:    'Les Régnières<br/>37320 ESVRES',
                    phone:      '06.61.61.59.56',
                    email:      'lebouchet.alain@wanadoo.fr',
                },
                {
                    type:       'Enseignant',
                    name:       'TYMCZUK Antoine',
                    image:      'images/bureau/enseignant.gif',
                    address:    '14, Allée des Jardins<br/>37550 SAINT-AVERTIN',
                    phone:      '06.83.50.74.36',
                    email:      '-',
                },
                {
                    type:       'Coordinateur',
                    name:       'MAINGOURD Olivier',
                    image:      'images/bureau/coordinateur.gif',
                    address:    '5, Rue Paul Boivinet<br/>37380 NOUZILLY',
                    phone:      '06.70.30.86.17',
                    email:      'o.maingourd@laposte.net',
                },
                {
                    type:       'Animatrice',
                    name:       'VOISIN Christine',
                    image:      'images/bureau/animation.gif',
                    address:    '37000 TOURS',
                    phone:      '06.32.04.60.68',
                    email:      '-',
                }
            ],
            faEnvelope, faPhone, faAt
        }
    },
    components: {
        Fa, hideAt, showAt
    },
    computed: {
        ...mapGetters({ 
            isRegistred: 'user/isRegistred', isAdmin: 'user/isAdmin',
            windowHeight: 'user/getWindowHeight', windowsWidth: 'user/getWindowWidth'
        }),
    },
    mounted() {
        const _self = this
        _self.$http
            .get('api/visitor/menu/3/' + _self.page)
            .then( response => {
                _self.articles = response.data.data.articles
                _self.nbArticles = _self.articles.length
                _self.loading = false
            })
    }
}
</script>

<style>
.table {
    width: 100%;
    margin-bottom: 20px
}

.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd
}

.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd
}

.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th {
    border-top: 0
}

.table>tbody+tbody {
    border-top: 2px solid #ddd
}

.table .table {
    background-color: #fff
}

.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th {
    padding: 5px
}

.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th {
    border: 1px solid #ddd
}

.table-bordered>thead>tr>td,.table-bordered>thead>tr>th {
    border-bottom-width: 2px
}

.table-striped>tbody>tr:nth-of-type(odd) {
    background-color: #f9f9f9
}

.table-hover>tbody>tr:hover,.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active {
    background-color: #f5f5f5
}

table col[class*=col-] {
    position: static;
    float: none;
    display: table-column
}

table td[class*=col-],table th[class*=col-] {
    position: static;
    float: none;
    display: table-cell
}

.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover {
    background-color: #e8e8e8
}

.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success {
    background-color: #dff0d8
}

.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover {
    background-color: #d0e9c6
}

.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info {
    background-color: #d9edf7
}

.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover {
    background-color: #c4e3f3
}

.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning {
    background-color: #fcf8e3
}

.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover {
    background-color: #faf2cc
}

.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger {
    background-color: #f2dede
}

.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover {
    background-color: #ebcccc
}

.table-responsive {
    overflow-x: auto;
    min-height: .01%
}

.h-avatar-image-container .h-avatar-image {
    position: absolute;
    z-index: 1;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    height: 75px;
    width: 100%;
}
</style>