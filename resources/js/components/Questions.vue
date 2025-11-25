<template>
    <div class="main-questions" style="margin: 2% 5% 0 5%">
        <div
            class="myQuestion"
            v-bind:id="'que' + index"
            v-for="(question, index) in questions"
            :key="index + uuid"
        >
            <div class="row">
                <form
                    class="myForm"
                    action="/quiz_start"
                    v-on:submit.prevent="
                        createQuestion(question.question_id, question.index)
                    "
                    method="post"
                >
                    <input
                        type="hidden"
                        name="queIndex"
                        class="form-control queIndx"
                        v-bind:value="index + 2"
                    />
                    <div class="row" v-if="set > 1">
                        <h3 style="color: white" v-html="question.set"></h3>
                    </div>
                    <div class="col-md-5 bg-white" style="margin-top: 2%">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 style="font-weight: 700; font-size: 1.5rem">
                                    Question: &nbsp;&nbsp;{{ index + 1 }}
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <h5
                                    style="
                                        font-weight: 700;
                                        font-size: 1.5rem;
                                        text-align: center;
                                    "
                                >
                                    Single Choice Type Question
                                </h5>
                            </div>
                        </div>
                        <hr />
                        <div class="q-block">
                            <div v-if="slug == 'english'">
                                <p
                                    v-if="index + 1 <= 5"
                                    style="
                                        font-size: 1.2rem;
                                        color: gray;
                                        margin-bottom: 30px;
                                    "
                                >
                                    Choose the letter that best represents your
                                    answer.
                                </p>
                                <p
                                    v-if="index + 1 > 5 && index + 1 <= 10"
                                    style="
                                        font-size: 1.2rem;
                                        color: gray;
                                        margin-bottom: 30px;
                                    "
                                >
                                    For nos. 6-10, choose the correct
                                    alternative of the given analogous pair.
                                </p>
                                <p
                                    v-if="index + 1 > 10 && index + 1 <= 15"
                                    style="
                                        font-size: 1.2rem;
                                        color: gray;
                                        margin-bottom: 30px;
                                    "
                                >
                                    For nos. 11-15, choose the synonym or the
                                    meaning of the underlined words.
                                </p>
                                <p
                                    v-if="index + 1 > 15 && index + 1 <= 20"
                                    style="
                                        font-size: 1.2rem;
                                        color: gray;
                                        margin-bottom: 30px;
                                    "
                                >
                                    For nos. 16-20, choose the word/s that
                                    make/s the sentence incorrect.
                                </p>
                            </div>
                            <p
                                v-if="slug != 'english'"
                                style="
                                    font-size: 1.2rem;
                                    color: gray;
                                    margin-bottom: 30px;
                                "
                            >
                                Choose the letter that best represents your
                                answer.
                            </p>
                            <p
                                class="question"
                                style="font-size: 1.4rem"
                                v-html="question.question"
                            ></p>
                        </div>
                        <div
                            class="tab-pane active"
                            id="textarea"
                            v-if="question.type == 'essay'"
                        >
                            <div class="q-block">
                                <p style="font-size: 1.2rem; color: gray">
                                    Answer
                                </p>
                            </div>
                            <div class="question-img-block">
                                <textarea
                                    class="form-control"
                                    rows="12"
                                    v-model="result.answer_exp"
                                ></textarea>
                            </div>
                        </div>
                        <div v-if="!question.choices.length" class="q-block">
                            <p style="font-size: 1.2rem; color: gray">
                                Choices
                            </p>
                        </div>
                        <div
                            class="choices-box"
                            v-if="question.type == 'multiple'"
                        >
                            <div
                                v-for="(choices, indx) in JSON.parse(
                                    question.choices
                                )"
                                :key="indx"
                            >
                                <label class="form-label">
                                    <input
                                        class="radioBtn"
                                        v-bind:id="'radio' + indx"
                                        type="radio"
                                        v-bind:value="choices"
                                        v-model="result.user_answer"
                                        aria-checked="false"
                                    />
                                    <span style="font-size: 1.4rem">{{
                                        choices
                                    }}</span>
                                </label>
                            </div>
                        </div>
                        <hr />
                        <div class="row" style="padding: 10px">
                            <div class="col-md-2 col-xs-8"></div>
                            <div
                                class="col-md-8 col-xs-8"
                                style="margin-top: 10%"
                            >
                                <button
                                    type="submit"
                                    class="btn btn-block nextbtn btn-primary"
                                    @click="status('save')"
                                    :disabled="isSelected"
                                    style="margin-top: 5px;"
                                >
                                    <span v-if="fcount != questions.length">Next</span><span v-else>Save</span>
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-block btn-warning nextbtn"
                                    @click="status('review')"
                                    :disabled="isSelected"
                                >
                                    <span>Review</span>
                                </button>
                                <button
                                    type="submit"
                                    v-if="fcount != questions.length"
                                    class="btn btn-block nextbtn btn-danger"
                                    @click="status('skipped')"
                                    :disabled="isDisabled"
                                >
                                    <span>Skip</span>
                                </button>
                                <button
                                    type="submit"
                                    v-if="
                                        fcount == questions.length &&
                                        topic_id != topics[topics.length - 1]
                                    "
                                    class="btn btn-block submitBtn btn-success"
                                >
                                    <span>Proceed</span>
                                </button>
                                <button
                                    type="submit"
                                    v-if="
                                        fcount == questions.length &&
                                        topic_id == topics[topics.length - 1]
                                    "
                                    class="btn btn-block submitBtn btn-success"
                                >
                                    <span>Submit</span>
                                </button>
                            </div>
                            <div class="col-md-2 col-xs-8"></div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h5 class="review-btn">
                            Question Overview
                            <span
                                class="glyphicon glyphicon-chevron-down"
                            ></span>
                        </h5>
                        <div class="sidepanel">
                            <div class="sidebar">
                                <h5 style="color: gray; font-weight: 800">
                                    Question
                                </h5>
                                <div
                                    style="display: inline-block"
                                    v-for="(basestats, indx) in stats"
                                    :key="indx"
                                >
                                    <input
                                        type="submit"
                                        class="base prebtn"
                                        v-bind:style="{
                                            backgroundColor:
                                                baseColors[basestats.status],
                                        }"
                                        :disabled="basestats.status === 'blank'"
                                        :value="indx + 1"
                                    />
                                </div>
                                <hr style="border-color: gray; width: 80%" />
                                <div class="row">
                                    <div
                                        class="col-md-6"
                                        style="text-align: center"
                                    >
                                        <div>
                                            <div class="span-ans"></div>
                                            <p class="inline">Answered</p>
                                        </div>
                                        <div>
                                            <div class="span-rev"></div>
                                            <p class="inline">For Review</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <div class="span-unans"></div>
                                            <p class="inline">Skipped</p>
                                        </div>
                                        <div>
                                            <div class="span-nvw"></div>
                                            <p class="inline">Not View</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="question-block-tabs"
                            v-if="
                                question.question_img != null ||
                                question.question_video_link != null ||
                                question.type == 'essay'
                            "
                        >
                            <h6 class="ques-image">
                                <span>Question Image</span>
                            </h6>
                            <hr style="margin-top: 0" />
                            <div class="tab-content">
                                <div
                                    class="tab-pane active"
                                    id="image"
                                    v-if="question.question_img != null"
                                >
                                    <div class="question-img-block">
                                        <img
                                            :src="
                                                '/storage/question_img/' +
                                                question.question_img
                                            "
                                            class="img-responsive"
                                            alt="question-image"
                                        />
                                    </div>
                                </div>
                                <!--<div class="tab-pane fade" id="video" v-if="question.question_video_link != null">
                <div class="question-video-block">
                  <h3 class="question-block-heading">Question Video</h3>
                  <iframe :id="'video'+(index+1)" width="460" height="345" :src="question.question_video_link" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>-->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { v4 as uuidv4 } from "uuid";
export default {
    props: ["topic_id"],

    data() {
        return {
            questions: [],
            answers: [],
            stats: [],
            auth: "",
            uuid: 0,
            topics: 0,
            count: 1,
            slug: "",
            fcount: 1,
            set: 0,
            baseColors: {
                save: "#46D96C",
                review: "#F8D612",
                skipped: "#EE6266",
                blank: "#e4e8eb",
            },
            result: {
                question_id: "",
                user_answer: null,
                topic_id: "",
                user_id: "",
                answer_exp: "",
                qIndex: null,
                status: "",
            },
        };
    },

    created() {
        this.fetchQuestions();
    },

    methods: {
        fetchQuestions() {
            axios
                .get(`${this.$props.topic_id}/quiz/${this.$props.topic_id}`)
                .then((response) => {
                    this.questions = response.data.questions;
                    this.topics = response.data.count;
                    this.auth = response.data.auth;
                    this.set = response.data.set;
                    this.slug = response.data.title;
                    this.stats = response.data.status;
                    this.uuid = uuidv4();
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        status(message) {
            this.result.status = message;
        },
        createQuestion(id, qindex) {
            this.result.qIndex = qindex;
            this.result.question_id = id;
            this.result.user_id = this.auth;
            this.result.topic_id = this.$props.topic_id;
            axios
                .post(`${this.$props.topic_id}/quiz`, this.result)
                .then((response) => {
                    let newdata = response.data.newdata;
                    this.questions.splice(newdata[0]["index"], 1, newdata[0]);
                    this.stats = response.data.status;
                })
                .catch((e) => {
                    console.log(e);
                });
            this.result.topic_id = "";
            this.result.answer_exp = this.result.answer_exp;
            this.result.user_answer = this.result.user_answer;
        },
        nxtClick() {
            var index = this.result.qIndex + 1;
            this.count = this.count + 1;
            if (index < this.questions.length) {
                this.result.user_answer = this.questions[index]["user_answer"];
                this.result.answer_exp = this.questions[index]["answer_exp"];
            } else {
                this.result.user_answer = this.result.user_answer;
                this.result.answer_exp = this.result.answer_exp;
            }
        },
        prvClick(i) {
            this.count = this.count - 1;
            this.result.user_answer = this.questions[i]["user_answer"];
            if (this.questions[i]["answer_exp"] != null) {
                this.result.answer_exp = this.questions[i]["answer_exp"];
            }
        },

        check() {
            return this.topics.length;
        },
    },
    computed: {
        isDisabled() {
            if (this.count == this.questions.length) {
                this.fcount = this.count;
                return true;
            } else if (!this.result.user_answer && !this.result.answer_exp) {
                return false;
            }
            return true;
        },
        isSelected() {
            if (this.result.user_answer || this.result.answer_exp) {
                return false;
            }
            return true;
        },
    },
};
</script>
