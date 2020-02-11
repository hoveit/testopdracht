<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Formulier</div>
                    <div class="card-body">
                        <div>
                            <b-form
                                v-if="show"
                                @submit="onSubmit"
                                @reset="onReset"
                            >
                                <b-form-group
                                    id="input-group-1"
                                    label="Aanhef:"
                                    label-for="input-1"
                                >
                                    <b-form-select
                                        id="input-1"
                                        v-model="form.aanhef"
                                        :options="aanhefKeuzes"
                                        required
                                        :state="stateAanhef"
                                    />
                                    <b-form-invalid-feedback
                                        :state="stateAanhef"
                                    >
                                        {{ invalidFeedbackAanhef }}
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-form-group
                                    id="input-group-2"
                                    label="Voornaam:"
                                    label-for="input-2"
                                >
                                    <b-form-input
                                        id="input-2"
                                        v-model="form.voornaam"
                                        required
                                        placeholder="voornaam"
                                        :state="stateVoornaam"
                                    />
                                    <b-form-invalid-feedback
                                        :state="stateVoornaam"
                                    >
                                        {{ invalidFeedbackVoornaam }}
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-form-group
                                    id="input-group-3"
                                    label="Tussenvoegsel:"
                                    label-for="input-3"
                                >
                                    <b-form-input
                                        id="input-3"
                                        v-model="form.tussenvoegsel"
                                        required
                                        placeholder="tussenvoegsel"
                                        :state="stateTussenvoegsel"
                                    />
                                    <b-form-invalid-feedback
                                        :state="stateTussenvoegsel"
                                    >
                                        {{ invalidFeedbackTussenvoegsel }}
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-form-group
                                    id="input-group-4"
                                    label="Achternaam:"
                                    label-for="input-4"
                                >
                                    <b-form-input
                                        id="input-4"
                                        v-model="form.achternaam"
                                        required
                                        placeholder="achternaam"
                                        :state="stateAchternaam"
                                    />
                                    <b-form-invalid-feedback
                                        :state="stateAchternaam"
                                    >
                                        {{ invalidFeedbackAchternaam }}
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-form-group
                                    id="input-group-5"
                                    label="E-mailadres:"
                                    label-for="input-5"
                                >
                                    <b-form-input
                                        id="input-5"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        placeholder="e-mailadres"
                                        :state="stateEmail"
                                    />
                                    <b-form-invalid-feedback
                                        :state="stateEmail"
                                    >
                                        {{ invalidFeedbackEmail }}
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <!-- <b-form-group
                                    id="input-group-6"
                                    label="Your Name:"
                                    label-for="input-6"
                                >
                                    <b-form-input
                                        id="input-6"
                                        v-model="form.name"
                                        required
                                        placeholder="Enter name"
                                        :state="stateName"
                                    />
                                    <b-form-invalid-feedback :state="stateName">
                                        {{ invalidFeedbackName }}
                                    </b-form-invalid-feedback>
                                </b-form-group> -->

                                <b-button type="submit" variant="primary"
                                    >Submit</b-button
                                >
                                <b-button type="reset" variant="danger"
                                    >Reset</b-button
                                >
                            </b-form>
                            <b-alert
                                :show="dismissCountDown"
                                dismissible
                                :variant="variant"
                                @dismissed="dismissCountDown = 0"
                                @dismiss-count-down="countDownChanged"
                                class="mt-3"
                            >
                                <p>
                                    {{ alertMessage }}
                                </p>
                                <b-progress
                                    :variant="variant"
                                    :max="dismissSecs"
                                    :value="dismissCountDown"
                                    height="4px"
                                ></b-progress>
                            </b-alert>
                            <b-card class="mt-3" header="Form Data Result">
                                <pre class="m-0">{{ form }}</pre>
                            </b-card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dismissSecs: 5,
            dismissCountDown: 0,
            form: {
                aanhef: null,
                voornaam: "",
                tussenvoegsel: "",
                achternaam: "",
                email: "",
                land: null
            },
            aanhefKeuzes: [
                { text: "Selecteer een aanhef", value: null },
                "Heer",
                "Mevrouw"
            ],
            alertMessage: "",
            variant: "",
            errors: {},
            show: true
        };
    },
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown;
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs;
        },
        onSubmit(evt) {
            evt.preventDefault();
            const formData = new FormData();
            formData.append("aanhef", this.form.aanhef);
            formData.append("voornaam", this.form.voornaam);
            formData.append("tussenvoegsel", this.form.tussenvoegsel);
            formData.append("achternaam", this.form.achternaam);
            formData.append("email", this.form.email);
            formData.append("land", this.form.land);
            // eslint-disable-next-line no-undef
            axios
                .post("/formulier", formData)
                .then(response => {
                    this.errors = {};
                    this.alertMessage = response.data.message;
                    this.variant = "success";
                    this.showAlert();
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.alertMessage = error.response.data.message;
                    this.variant = "danger";
                    this.showAlert();
                });
        },
        onReset(evt) {
            evt.preventDefault();
            this.form.aanhef = null;
            this.form.voornaam = "";
            this.form.tussenvoegsel = "";
            this.form.achternaam = "";
            this.form.email = "";
            this.form.land = null;
            this.$nextTick(() => {
                this.show = true;
            });
        }
    },
    computed: {
        invalidFeedbackAanhef() {
            if (this.errors.aanhef) {
                return this.errors.aanhef[0];
            } else {
                return null;
            }
        },
        stateAanhef() {
            if (this.errors.aanhef) {
                return false;
            } else {
                return null;
            }
        },
        invalidFeedbackVoornaam() {
            if (this.errors.voornaam) {
                return this.errors.voornaam[0];
            } else {
                return null;
            }
        },
        stateVoornaam() {
            if (this.errors.voornaam) {
                return false;
            } else {
                return null;
            }
        },
        invalidFeedbackTussenvoegsel() {
            if (this.errors.tussenvoegsel) {
                return this.errors.tussenvoegsel[0];
            } else {
                return null;
            }
        },
        stateTussenvoegsel() {
            if (this.errors.tussenvoegsel) {
                return false;
            } else {
                return null;
            }
        },
        invalidFeedbackAchternaam() {
            if (this.errors.achternaam) {
                return this.errors.achternaam[0];
            } else {
                return null;
            }
        },
        stateAchternaam() {
            if (this.errors.achternaam) {
                return false;
            } else {
                return null;
            }
        },
        invalidFeedbackEmail() {
            if (this.errors.email) {
                return this.errors.email[0];
            } else {
                return null;
            }
        },
        stateEmail() {
            if (this.errors.email) {
                return false;
            } else {
                return null;
            }
        },
        invalidFeedbackLand() {
            if (this.errors.land) {
                return this.errors.land[0];
            } else {
                return null;
            }
        },
        stateLand() {
            if (this.errors.land) {
                return false;
            } else {
                return null;
            }
        }
    }
};
</script>
