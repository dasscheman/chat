
<template>
    <ul class="dilemma">
      <div class="card-header">Dilemma's</div>
      <ul class="list-group">
          <li class="list-group-item" v-for="dilemma in dilemmas">
            <!-- {{ test(dilemma)}} -->
              <strong>
                  {{ dilemma.naam }}
              </strong>
              <p>
                  {{ dilemma.dilemma }}
              </p>
              <span v-if="dilemma.show_buttons">
                  <button  class="badge badge-success btn-sm" id="btn-dilemma-cooperate" @click="sendCooperate(dilemma)">
                      Samenwerken
                  </button>
                  <button  class="badge badge-danger btn-sm" id="btn-dilemma-cooperate" @click="sendSabotage(dilemma)">
                      Saboteren
                  </button>
              </span>
              <span v-else>
                  <span v-if="dilemma.show_result">
                      {{dilemma.show_result}}
                      Het dillema is gespeeld en dit is de boodschap:
                      {{ dilemma.result }}
                  </span>
                  <span v-else>
                      <span v-if="dilemma.wait_on_other_player">
                          tegen party heeft een keuze gemaakt en wacht op jou.
                      </span>
                      <span v-if="dilemma.current_user_finished">
                          Jij hebt dit dilemma al gespeeld
                      </span>
                      <span v-if="dilemma.other_user_finished">
                          Deze speler heeft dit al gespeeld
                      </span>
                      <span v-if="dilemma.startd_with_other_user">
                          Je bent dit dilemma al met deze speler begonnen.
                      </span>
                  </span>
              </span>
          </li>
      </ul>
    </ul>
</template>

<script>
    export default {
        props: ['dilemmas', 'userid', 'to_user'],

        data() {
            return {
                uitkomsten: '',
                dilemma: ''
            }
        },
        methods: {
            sendCooperate(dilemma) {
                console.log('sendCooperate')
                axios.post('/dilemma', {
                    dilemma: dilemma.id,
                    choise: 1,
                    to_user: this.to_user
                }).then(response => {
                    console.log('emit')
                    this.$emit('uitkomstsent', {
                        user: this.user
                    });
                });
            },
            sendSabotage(dilemma) {
                console.log('sendSabotage')
                axios.post('/dilemma', {
                    dilemma: dilemma.id,
                    choise: 2,
                    to_user: this.to_user
                }).then(response => {
                    console.log('emit')
                    this.$emit('uitkomstsent', {
                        user: this.user
                    });
                });
            },
        }
    };
</script>
