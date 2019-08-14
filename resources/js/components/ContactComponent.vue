<template>
    <div style="background: rgb(255, 255, 255); padding: 24px; min-height: 680px;">
        <h2>Localisation</h2>
        <Row :space-x="10" type="flex" v-height="75" align="middle">
            <Cell width="4">
                Adresse du dojo 
            </Cell>
            <Cell width="6">
                Rue de Verdun<br/>
                37550, Saint-Avertin
            </Cell>
        </Row>
        <Row :space-x="10" type="flex" v-height="500" align="middle" justify="space-around">
            <div style="height: 600px; width: 100%">
                <l-map
                    style="height: 80%; width: 100%"
                    :zoom="zoom"
                    :center="center"
                    @update:zoom="zoomUpdated"
                    @update:center="centerUpdated"
                    @update:bounds="boundsUpdated"
                    >
                    <l-tile-layer :url="url"></l-tile-layer>
                    <l-marker :lat-lng="marker">
                        <l-tooltip>
                            Rue de Verdun
                            37550, Saint-Avertin
                        </l-tooltip>
                    </l-marker>
                </l-map>
            </div>
        </Row>
        <Row :space-x="10" type="flex" v-height="75" align="middle">
            <h2>Contact</h2>
        </Row>
        <Form
            ref="contactForm"
            :showErrorTip="showErrorTip"
            :labelPosition="labelPosition"
            :labelWidth="130"
            :model="contactForm"
            mode="single"
            >
            <Row :space-x="10" type="flex" v-height="50" align="middle" justify="space-around">
                <Cell width="6">
                    <FormItem label="Nom" prop="name">
                        <input type="text" v-model="contactForm.name">
                    </FormItem>
                </Cell>
                <Cell width="6">
                    <FormItem label="Adresse e-mail" prop="email">
                        <input type="text" v-model="contactForm.email">
                    </FormItem>
                </Cell>
                <Cell width="6">
                    <FormItem label="Sujet" prop="subject">
                        <input type="text" v-model="contactForm.subject">
                    </FormItem>
                </Cell>
            </Row>
            <Row :space-x="10" type="flex" v-height="100" align="middle" justify="space-around">
                <Cell width="24">
                    <FormItem label="Message" prop="name">
                        <textarea v-autosize v-model="contactForm.content"></textarea>
                    </FormItem>
                </Cell>
            </Row>
            <Row :space-x="10" type="flex" v-height="50" align="middle" justify="space-around">
                <Cell width="3">
                    <Button color="primary" @click="submit">Envoyer</Button>
                </Cell>
            </Row>
        </Form>
        
    </div>   
</template>

<script>
import {LMap, LTileLayer, LMarker, LTooltip} from 'vue2-leaflet'

export default {
    data () {
        return {
            url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
            zoom: 18,
            center: [47.365569, 0.736566],
            marker: L.latLng(47.365569, 0.736566),
            bounds: null,
            contactForm: {
                name:       '',
                email:      '',
                subject:    '',
                content:    ''
            },
            labelPosition: 'right',
            showErrorTip: true,

        }
    },
    components: { LMap, LTileLayer, LMarker, LTooltip },
    methods: {
        zoomUpdated (zoom) {
            this.zoom = zoom;
        },
        centerUpdated (center) {
            this.center = center;
        },
        boundsUpdated (bounds) {
            this.bounds = bounds;
        },
        submit() {
            const _self = this
            let errors = false
            if (_self.contactForm.name.length == 0) {
                _self.$Message.error('Veuillez indiquer votre nom')
                errors = true
            }
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(String(_self.contactForm.email).toLowerCase())) {
                _self.$Message.error('Veuillez indiquer une adresse email')
                errors = true
            }
            if (_self.contactForm.subject.length == 0) {
                _self.$Message.error('Veuillez indiquer le sujet')
                errors = true
            }
            if (_self.contactForm.content.length == 0) {
                _self.$Message.error('Veuillez indiquer votre message')
                errors = true
            }
            if (!errors) {
                _self.$Message('Envoi du message.')
            }
        }
    }
}
</script>

<style>

</style>