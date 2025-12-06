<template>
    <!-- <div class="row mb-4" v-if="set > 1">
        <div class="col-12">
            <div class="alert alert-info">
                <h3 class="mb-0 text-white" v-html="set"></h3>
            </div>
        </div>
    </div> -->
    <div class="main-questions">
        <div
            class="myQuestion"
            v-bind:id="'que' + index"
            v-for="(question, index) in questions"
            :key="index + uuid"
            v-show="count === index + 1"
        >
            <div class="row g-4">
                <form
                    class="myForm row"
                    @submit.prevent="
                        createQuestion(question.question_id, question.index)
                    "
                >
                    <input
                        type="hidden"
                        name="queIndex"
                        class="form-control queIndx"
                        v-bind:value="index + 1"
                    />

                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h5
                                            class="card-title mb-0 fw-bold fs-4"
                                        >
                                            <i
                                                class="bi bi-question-circle me-2"
                                            ></i>
                                            Question: {{ index + 1 }}
                                        </h5>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h5
                                            class="card-title mb-0 fw-bold fs-4"
                                        >
                                            Single Choice Type Question
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Instructions -->
                                <div class="instruction-box mb-4">
                                    <div v-if="slug == 'english'">
                                        <div
                                            class="alert alert-light border"
                                            v-if="index + 1 <= 5"
                                        >
                                            <p class="mb-0 fs-5 text-muted">
                                                <i
                                                    class="bi bi-info-circle me-2"
                                                ></i>
                                                Choose the letter that best
                                                represents your answer.
                                            </p>
                                        </div>
                                        <div
                                            class="alert alert-light border"
                                            v-if="
                                                index + 1 > 5 && index + 1 <= 10
                                            "
                                        >
                                            <p class="mb-0 fs-5 text-muted">
                                                <i
                                                    class="bi bi-info-circle me-2"
                                                ></i>
                                                For nos. 6-10, choose the
                                                correct alternative of the given
                                                analogous pair.
                                            </p>
                                        </div>
                                        <div
                                            class="alert alert-light border"
                                            v-if="
                                                index + 1 > 10 &&
                                                index + 1 <= 15
                                            "
                                        >
                                            <p class="mb-0 fs-5 text-muted">
                                                <i
                                                    class="bi bi-info-circle me-2"
                                                ></i>
                                                For nos. 11-15, choose the
                                                synonym or the meaning of the
                                                underlined words.
                                            </p>
                                        </div>
                                        <div
                                            class="alert alert-light border"
                                            v-if="
                                                index + 1 > 15 &&
                                                index + 1 <= 20
                                            "
                                        >
                                            <p class="mb-0 fs-5 text-muted">
                                                <i
                                                    class="bi bi-info-circle me-2"
                                                ></i>
                                                For nos. 16-20, choose the
                                                word/s that make/s the sentence
                                                incorrect.
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="alert alert-light border"
                                        v-else
                                    >
                                        <p class="mb-0 fs-5 text-muted">
                                            <i
                                                class="bi bi-info-circle me-2"
                                            ></i>
                                            Choose the letter that best
                                            represents your answer.
                                        </p>
                                    </div>
                                </div>

                                <!-- Question -->
                                <div class="question-content mb-4">
                                    <div class="p-3 bg-light rounded">
                                        <p
                                            class="question mb-0 fs-4"
                                            v-html="question.question"
                                        ></p>
                                    </div>
                                </div>

                                <!-- Essay Answer -->
                                <div
                                    class="tab-pane active"
                                    v-if="question.type == 'essay'"
                                >
                                    <div class="q-block mb-3">
                                        <p class="text-muted mb-2 fs-5">
                                            Answer
                                        </p>
                                    </div>
                                    <div class="question-img-block">
                                        <textarea
                                            class="form-control"
                                            rows="12"
                                            v-model="currentQuestionAnswerExp"
                                            placeholder="Type your answer here..."
                                            @input="onEssayInput"
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Choices -->
                                <div
                                    v-if="
                                        !question.choices ||
                                        parsedChoices(question.choices)
                                            .length === 0
                                    "
                                    class="q-block mb-3"
                                >
                                    <p class="text-muted mb-2 fs-5">Choices</p>
                                </div>

                                <div
                                    class="choices-box"
                                    v-if="question.type === 'multiple'"
                                >
                                    <div
                                        v-for="(choice, indx) in parsedChoices(
                                            question.choices
                                        )"
                                        :key="indx"
                                        class="mb-3"
                                    >
                                        <div
                                            class="form-check choice-item"
                                            :class="{
                                                selected:
                                                    currentQuestionUserAnswer ===
                                                    String(choice),
                                            }"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :name="
                                                    'question_' +
                                                    question.question_id
                                                "
                                                :id="
                                                    'radio_' +
                                                    question.question_id +
                                                    '_' +
                                                    indx
                                                "
                                                :value="String(choice)"
                                                v-model="
                                                    currentQuestionUserAnswer
                                                "
                                                @change="onChoiceChange"
                                            />
                                            <label
                                                class="form-check-label w-100"
                                                :for="
                                                    'radio_' +
                                                    question.question_id +
                                                    '_' +
                                                    indx
                                                "
                                            >
                                                <span
                                                    class="choice-text fs-4"
                                                    >{{ choice }}</span
                                                >
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card-footer bg-white border-top p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <button
                                            type="submit"
                                            class="btn btn-primary w-100 py-3 nextbtn"
                                            @click="status('save')"
                                            :disabled="isSaveDisabled"
                                        >
                                            <i
                                                class="bi bi-arrow-right-circle me-2"
                                            ></i>
                                            <span v-if="!isLast">Next</span>
                                            <span v-else>Save</span>
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            type="submit"
                                            class="btn btn-warning w-100 py-3 nextbtn"
                                            @click="status('review')"
                                            :disabled="isSaveDisabled"
                                        >
                                            <i
                                                class="bi bi-clock-history me-2"
                                            ></i>
                                            Review
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            type="submit"
                                            v-if="!isLast"
                                            class="btn btn-danger w-100 py-3 nextbtn"
                                            @click="status('skipped')"
                                            :disabled="isSkipDisabled"
                                        >
                                            <i
                                                class="bi bi-skip-forward me-2"
                                            ></i>
                                            Skip
                                        </button>

                                        <button
                                            type="submit"
                                            v-if="
                                                isLast &&
                                                topic_id !=
                                                    topics[topics.length - 1]
                                            "
                                            class="btn btn-success w-100 py-3 submitBtn"
                                            :disabled="isSubmitDisabled"
                                        >
                                            <i
                                                class="bi bi-arrow-right me-2"
                                            ></i>
                                            Proceed
                                        </button>

                                        <button
                                            type="submit"
                                            v-if="
                                                isLast &&
                                                topic_id ==
                                                    topics[topics.length - 1]
                                            "
                                            class="btn btn-success w-100 py-3 submitBtn"
                                            :disabled="isSubmitDisabled"
                                        >
                                            <i
                                                class="bi bi-check-circle me-2"
                                            ></i>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="col-lg-6">
                        <!-- Question Overview -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div
                                class="card-header bg-white border-bottom review-btn"
                                style="cursor: pointer"
                            >
                                <h5
                                    class="mb-0 d-flex justify-content-between align-items-center"
                                >
                                    <span>
                                        <i class="bi bi-grid-3x3-gap me-2"></i>
                                        Question Overview
                                    </span>
                                    <i class="bi bi-chevron-down"></i>
                                </h5>
                            </div>

                            <div
                                class="sidepanel card-body"
                                :style="{ display: openOnNext && 'block' }"
                            >
                                <div class="sidebar">
                                    <h5 class="text-muted fw-bold mb-4">
                                        Question
                                    </h5>
                                    <div class="question-grid mb-4">
                                        <button
                                            type="button"
                                            class="btn prebtn question-btn"
                                            :class="
                                                getQuestionButtonClass(
                                                    basestats.status
                                                )
                                            "
                                            v-for="(basestats, indx) in stats"
                                            :key="indx"
                                            @click="goToQuestion(indx)"
                                            :disabled="
                                                basestats.status === 'blank' ||
                                                basestats.status === 'save'
                                            "
                                            :value="indx + 1"
                                            :title="'Question ' + (indx + 1)"
                                        >
                                            {{ indx + 1 }}
                                        </button>
                                    </div>

                                    <hr class="my-4" />

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div
                                                class="d-flex align-items-center mb-3"
                                            >
                                                <div
                                                    class="status-indicator bg-success me-3"
                                                ></div>
                                                <span class="fw-medium"
                                                    >Answered</span
                                                >
                                            </div>
                                            <div
                                                class="d-flex align-items-center mb-3"
                                            >
                                                <div
                                                    class="status-indicator bg-warning me-3"
                                                ></div>
                                                <span class="fw-medium"
                                                    >For Review</span
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                class="d-flex align-items-center mb-3"
                                            >
                                                <div
                                                    class="status-indicator bg-danger me-3"
                                                ></div>
                                                <span class="fw-medium"
                                                    >Skipped</span
                                                >
                                            </div>
                                            <div
                                                class="d-flex align-items-center mb-3"
                                            >
                                                <div
                                                    class="status-indicator bg-secondary me-3"
                                                ></div>
                                                <span class="fw-medium"
                                                    >Not Viewed</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Question Media -->
                        <div
                            class="card shadow-sm border-0"
                            v-if="
                                question.question_img != null ||
                                question.question_video_link != null ||
                                (question.type == 'essay' &&
                                    question.question_img != null)
                            "
                        >
                            <div class="card-header bg-white border-bottom">
                                <h6 class="mb-0">
                                    <i class="bi bi-card-image me-2"></i>
                                    Question Image
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div
                                        class="tab-pane active"
                                        v-if="question.question_img != null"
                                    >
                                        <div
                                            class="question-img-block text-center"
                                        >
                                            <img
                                                :src="
                                                    '/storage/question_img/' +
                                                    question.question_img
                                                "
                                                class="img-fluid rounded shadow-sm w-100"
                                                alt="Question Image"
                                                style="max-height: 500px"
                                            />
                                        </div>
                                    </div>
                                </div>
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
            openOnNext: false,
            // Track current question state separately
            currentQuestionState: {
                user_answer: null,
                answer_exp: "",
            },
        };
    },

    created() {
        this.fetchQuestions();
    },

    watch: {
        count(newCount) {
            const idx = newCount - 1;
            if (idx >= 0 && idx < this.questions.length) {
                // Update result with current question data
                this.result.qIndex = idx;
                this.result.question_id = this.questions[idx].question_id;

                // Load current question's saved answer
                const question = this.questions[idx];
                this.currentQuestionState.user_answer =
                    question.user_answer ?? null;
                this.currentQuestionState.answer_exp =
                    question.answer_exp ?? "";

                // Also update result for API
                this.result.user_answer = question.user_answer ?? null;
                this.result.answer_exp = question.answer_exp ?? "";
            }
        },
    },

    computed: {
        currentQuestion() {
            return this.questions[this.count - 1] || null;
        },

        currentQuestionUserAnswer: {
            get() {
                return this.currentQuestionState.user_answer;
            },
            set(value) {
                this.currentQuestionState.user_answer = value;
                this.result.user_answer = value;
            },
        },

        currentQuestionAnswerExp: {
            get() {
                return this.currentQuestionState.answer_exp;
            },
            set(value) {
                this.currentQuestionState.answer_exp = value;
                this.result.answer_exp = value;
            },
        },

        isLast() {
            return this.count === this.questions.length;
        },

        // Fix: Check if current question has an answer
        hasAnswer() {
            if (!this.currentQuestion) return false;

            // For multiple choice
            if (this.currentQuestion.type === "multiple") {
                return (
                    this.currentQuestionState.user_answer !== null &&
                    this.currentQuestionState.user_answer !== ""
                );
            }

            // For essay questions
            if (this.currentQuestion.type === "essay") {
                return (
                    this.currentQuestionState.answer_exp !== null &&
                    this.currentQuestionState.answer_exp !== ""
                );
            }

            return false;
        },

        // Fix: Only disable Save/Review if no answer AND it's not an essay question
        isSaveDisabled() {
            if (this.currentQuestion && this.currentQuestion.type === "essay") {
                // For essay questions, allow saving even with empty answer
                return false;
            }
            return !this.hasAnswer;
        },

        // Skip should only be disabled on last question
        isSkipDisabled() {
            return this.isLast;
        },

        // Submit/Proceed should only be disabled if it's not the last question
        isSubmitDisabled() {
            return !this.isLast;
        },
    },

    methods: {
        getQuestionButtonClass(status) {
            const colorMap = {
                save: "btn-success",
                review: "btn-warning",
                skipped: "btn-danger",
                blank: "btn-secondary",
            };
            return colorMap[status] || "btn-secondary";
        },

        goToQuestion(index) {
            if (index >= 0 && index < this.questions.length) {
                this.count = index + 1;
                this.result.qIndex = index;

                // Load the question's saved answer
                const question = this.questions[index];
                this.currentQuestionState.user_answer =
                    question.user_answer ?? null;
                this.currentQuestionState.answer_exp =
                    question.answer_exp ?? "";
                this.result.user_answer = question.user_answer ?? null;
                this.result.answer_exp = question.answer_exp ?? "";
                this.result.question_id = question.question_id;

                const currentActive =
                    document.querySelector(".myQuestion.active");
                if (currentActive) currentActive.classList.remove("active");

                const target = document.getElementById("que" + index);
                if (target) target.classList.add("active");
            }
        },

        onChoiceChange() {
            // When a choice is selected, enable the buttons
            console.log("Choice changed:", this.currentQuestionUserAnswer);
        },

        onEssayInput() {
            // When essay text changes, enable the buttons
            console.log("Essay input:", this.currentQuestionAnswerExp);
        },

        parsedChoices(raw) {
            if (!raw) return [];
            try {
                const choices = typeof raw === "string" ? JSON.parse(raw) : raw;
                return choices.map((c) => String(c));
            } catch (e) {
                console.error("CHOICES JSON ERROR:", raw);
                return [];
            }
        },

        fetchQuestions() {
            axios
                .get(`${this.$props.topic_id}/quiz/${this.$props.topic_id}`)
                .then((response) => {
                    this.questions = response.data.questions.map((q, index) => {
                        return {
                            ...q,
                            index: index,
                            user_answer:
                                q.user_answer != null
                                    ? String(q.user_answer)
                                    : null,
                            answer_exp: q.answer_exp ?? "",
                            choices: this.parseChoices(q.choices),
                        };
                    });
                    this.topics = response.data.count;
                    this.auth = response.data.auth;
                    this.set = response.data.set;
                    this.slug = response.data.title;
                    this.stats = response.data.status;
                    this.uuid = uuidv4();

                    if (this.questions && this.questions.length > 0) {
                        // Initialize with first question
                        const firstQuestion = this.questions[0];
                        this.result.qIndex = 0;
                        this.result.question_id = firstQuestion.question_id;
                        this.currentQuestionState.user_answer =
                            firstQuestion.user_answer ?? null;
                        this.currentQuestionState.answer_exp =
                            firstQuestion.answer_exp ?? "";
                        this.result.user_answer =
                            firstQuestion.user_answer ?? null;
                        this.result.answer_exp = firstQuestion.answer_exp ?? "";
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        parseChoices(choices) {
            if (!choices) return [];
            try {
                if (typeof choices === "string") {
                    return JSON.parse(choices);
                }
                return choices;
            } catch (e) {
                console.error("Error parsing choices:", e);
                return [];
            }
        },

        status(message) {
            this.result.status = message;
        },

        createQuestion(id, qindex) {
            this.result.qIndex = qindex;
            this.result.question_id = id;
            this.result.user_id = this.auth;
            this.result.topic_id = this.$props.topic_id;
            this.openOnNext = true;

            // Make sure we have the latest values
            this.result.user_answer = this.currentQuestionState.user_answer;
            this.result.answer_exp = this.currentQuestionState.answer_exp;

            axios
                .post(`${this.$props.topic_id}/quiz`, this.result)
                .then((response) => {
                    let newdata = response.data.newdata;
                    if (newdata && newdata[0]) {
                        const nd = newdata[0];
                        nd.user_answer =
                            nd.user_answer != null
                                ? String(nd.user_answer)
                                : null;
                        nd.answer_exp = nd.answer_exp ?? "";

                        // Update the question in our array
                        this.questions[nd.index] = {
                            ...this.questions[nd.index],
                            user_answer: nd.user_answer,
                            answer_exp: nd.answer_exp,
                            status: nd.status || "save",
                        };

                        // If this is the current question, update local state
                        if (this.result.qIndex === nd.index) {
                            this.currentQuestionState.user_answer =
                                nd.user_answer ?? null;
                            this.currentQuestionState.answer_exp =
                                nd.answer_exp ?? "";
                        }
                    }
                    this.stats = response.data.status;
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        nxtClick() {
            let index = this.result.qIndex + 1;
            if (index < this.questions.length) {
                this.count = index + 1;
                this.result.qIndex = index;
                this.result.question_id = this.questions[index].question_id;

                // Load the next question's saved answer
                const question = this.questions[index];
                this.currentQuestionState.user_answer =
                    question.user_answer ?? null;
                this.currentQuestionState.answer_exp =
                    question.answer_exp ?? "";
                this.result.user_answer = question.user_answer ?? null;
                this.result.answer_exp = question.answer_exp ?? "";
            }
        },

        prvClick(i) {
            if (i >= 0 && i < this.questions.length) {
                this.count = i + 1;
                this.result.qIndex = i;
                this.result.question_id = this.questions[i].question_id;

                // Load the previous question's saved answer
                const question = this.questions[i];
                this.currentQuestionState.user_answer =
                    question.user_answer ?? null;
                this.currentQuestionState.answer_exp =
                    question.answer_exp ?? "";
                this.result.user_answer = question.user_answer ?? null;
                this.result.answer_exp = question.answer_exp ?? "";
            }
        },

        check() {
            return this.topics.length;
        },
    },
};
</script>

<style scoped>
.main-questions {
    padding: 20px 0;
}

.myQuestion {
    display: none;
}

.myQuestion.active {
    display: block;
}

/* Choice item styling */
.choice-item {
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.choice-item:hover {
    border-color: #86b7fe;
    background-color: #f8f9fa;
}

.choice-item.selected {
    border-color: #0d6efd;
    background-color: #e7f1ff;
}

.form-check-input {
    width: 22px;
    height: 22px;
    margin-top: 0.3rem;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.choice-text {
    padding-left: 15px;
    line-height: 1.5;
}

/* Question grid for navigation */
.question-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 10px;
}

.question-btn {
    width: 45px;
    height: 45px;
    border-radius: 8px;
    border: none;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.question-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.question-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-success {
    background-color: #46d96c !important;
    border-color: #46d96c !important;
}

.btn-warning {
    background-color: #f8d612 !important;
    border-color: #f8d612 !important;
    color: #212529 !important;
}

.btn-danger {
    background-color: #ee6266 !important;
    border-color: #ee6266 !important;
}

.btn-secondary {
    background-color: #e4e8eb !important;
    border-color: #e4e8eb !important;
    color: #495057 !important;
}

/* Status indicators */
.status-indicator {
    width: 20px;
    height: 20px;
    border-radius: 4px;
}

.bg-success {
    background-color: #46d96c !important;
}

.bg-warning {
    background-color: #f8d612 !important;
}

.bg-danger {
    background-color: #ee6266 !important;
}

.bg-secondary {
    background-color: #e4e8eb !important;
}

/* Sidepanel animation */
.sidepanel {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .question-grid {
        grid-template-columns: repeat(5, 1fr);
    }

    .choice-item {
        padding: 15px;
    }

    .choice-text {
        font-size: 1.1rem !important;
    }
}

@media (max-width: 768px) {
    .question-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .question-btn {
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }

    .card-header h5 {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .question-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .main-questions {
        padding: 10px 0;
    }
}
</style>
