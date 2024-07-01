<template>
  <div class="container">
    <div class="__hero">
      <div class="hero__description">
        <h3>{{ $t("landing.heroSection.empower") }}</h3>
        <p>
          {{ $t("landing.heroSection.description") }}
        </p>
        <div class="hero__buttons">
          <button class="custom-btn active">
            {{ $t("landing.heroSection.exploreMoreBtn") }}
          </button>
          <button class="custom-btn">
            {{ $t("landing.heroSection.getStartedBtn") }}
          </button>
        </div>
      </div>
      <div class="hero__image">
        <img src="../assets/images/hero-image.png" />
      </div>
    </div>
    <!-- Hero  -->
    <div class="right-bg">
      <img src="../assets/images/bg-transparent.png" srcset="" />
    </div>
    <div class="left-bg">
      <img src="../assets/images/bg-transparent.png" srcset="" />
    </div>
  </div>

  <div class="video__section">
    <video
      src="../assets/images/file_example_MP4_1280_10MG.mp4"
      autoplay
      muted
      loop
    ></video>
    <div class="content">
      <div class="content__data">
        <h1>{{ $t("landing.videoSection.title") }}</h1>
        <p>{{ $t("landing.videoSection.description") }}</p>
        <button class="custom-btn active">
          {{ $t("landing.videoSection.videoBtn") }}
        </button>
      </div>
    </div>
  </div>

  <div class="works">
    <div class="work__desc">
      <h1>{{ $t("landing.works.title") }}</h1>
      <p>{{ $t("landing.works.description") }}</p>
      <button class="custom-btn">{{ $t("landing.works.btn") }}</button>
    </div>
    <div class="works__box">
      <div class="box" id="box1">
        <div>
          <img src="../assets/images/icon-1.png" alt="" srcset="" />
        </div>
        <h3>{{ $t("landing.works.cards.registerTitle") }}</h3>
        <p>{{ $t("landing.works.cards.registerDescription") }}</p>
      </div>
      <div class="box2" id="box2">
        <div>
          <img src="../assets/images/icon-2.png" alt="" srcset="" />
        </div>
        <h3>{{ $t("landing.works.cards.projectTitle") }}</h3>
        <p>{{ $t("landing.works.cards.projectDescription") }}</p>
      </div>
      <div class="box" id="box3">
        <div>
          <img src="../assets/images/icon-3.png" alt="" srcset="" />
        </div>
        <h3>{{ $t("landing.works.cards.participantTitle") }}</h3>
        <p>{{ $t("landing.works.cards.participantDescription") }}</p>
      </div>
      <div class="box2" id="box4">
        <div>
          <img src="../assets/images/icon-4.png" alt="" srcset="" />
        </div>
        <h3>{{ $t("landing.works.cards.sessionsTitle") }}</h3>
        <p>{{ $t("landing.works.cards.sessionsDescription") }}</p>
      </div>
      <div class="box" id="box5">
        <div>
          <img src="../assets/images/icon-5.png" alt="" srcset="" />
        </div>
        <h3>{{ $t("landing.works.cards.feedbackTitle") }}</h3>
        <p>{{ $t("landing.works.cards.feedbackDescription") }}</p>
      </div>
    </div>
  </div>

  <div class="reviews__section">
    <div class="reviews">
      <div class="reviews__desc">
        <h1>{{ $t("landing.reviews.title") }}</h1>
        <p>{{ $t("landing.reviews.description") }}</p>
      </div>
      <div class="user__reviews">
        <div class="user__data">
          <div class="user__details active">
            <div class="user__image">
              <img src="../assets/images/user-1.jpg" alt="" />
            </div>
            <div class="user__info">
              <h3 class="username">
                {{ $t("landing.reviews.comment.username1") }}
              </h3>
              <small>{{ $t("landing.reviews.comment.designation1") }}</small>
            </div>
          </div>
          <div class="user__details">
            <div class="user__image">
              <img src="../assets/images/user-02.jpg" alt="" />
            </div>
            <div class="user__info">
              <h3 class="username">
                {{ $t("landing.reviews.comment.username2") }}
              </h3>
              <small>{{ $t("landing.reviews.comment.designation2") }}</small>
            </div>
          </div>
          <div class="user__details">
            <div class="user__image">
              <img src="../assets/images/user-03.jpg" alt="" />
            </div>
            <div class="user__info">
              <h3 class="username">
                {{ $t("landing.reviews.comment.username3") }}
              </h3>
              <small>{{ $t("landing.reviews.comment.designation3") }}</small>
            </div>
          </div>
        </div>
        <div class="user__data user__comment">
          <div class="comment__title">
            <h2>{{ $t("landing.reviews.comment.title1") }}</h2>
            <span>
              <i class="ri-star-fill" style="color: #ffd43b"></i>
              <i class="ri-star-fill" style="color: #ffd43b"></i>
              <i class="ri-star-fill" style="color: #ffd43b"></i>
              <i class="ri-star-fill" style="color: #ffd43b"></i>
              <i class="ri-star-fill" style="color: #ffd43b"></i>
            </span>
            <small>{{ $t("landing.reviews.comment.body1") }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="faqs">
    <h1>{{ $t("landing.faqs.title") }}</h1>
    <div class="faqs__accordin">
      <div class="demo-collapse">
        <el-collapse
          v-model="activeNames"
          @change="handleChange"
          style="font-family: 'GraphikRegular'"
        >
          <el-collapse-item title="Consistency" name="1">
            <div>
              Consistent with real life: in line with the process and logic of real life,
              and comply with languages and habits that the users are used to;
            </div>
            <div>
              Consistent within interface: all elements should be consistent, such as:
              design style, icons and texts, position of elements, etc.
            </div>
          </el-collapse-item>
          <el-collapse-item title="Feedback" name="2">
            <div>
              Operation feedback: enable the users to clearly perceive their operations by
              style updates and interactive effects;
            </div>
            <div>
              Visual feedback: reflect current state by updating or rearranging elements
              of the page.
            </div>
          </el-collapse-item>
          <el-collapse-item title="Efficiency" name="3">
            <div>Simplify the process: keep operating process simple and intuitive;</div>
            <div>
              Definite and clear: enunciate your intentions clearly so that the users can
              quickly understand and make decisions;
            </div>
            <div>
              Easy to identify: the interface should be straightforward, which helps the
              users to identify and frees them from memorizing and recalling.
            </div>
          </el-collapse-item>
          <el-collapse-item title="Controllability" name="4">
            <div>
              Decision making: giving advices about operations is acceptable, but do not
              make decisions for the users;
            </div>
            <div>
              Controlled consequences: users should be granted the freedom to operate,
              including canceling, aborting or terminating current operation.
            </div>
          </el-collapse-item>
        </el-collapse>
      </div>
    </div>
    <button class="custom-btn">{{ $t("landing.faqs.btn") }}</button>
  </div>

  <div class="subscribe">
    <div class="subs_desc">
      <h1>{{ $t("landing.subscribe.title") }}</h1>
      <form>
        <div class="form__data">
          <input type="text" placeholder="Enter your email" />
          <button class="subscribe-btn active" type="submit">
            {{ $t("landing.subscribe.btn") }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts" name="landing">
import { useI18n } from "vue-i18n";
import { ref } from "vue";

const { t } = useI18n();

const activeNames = ref(["1"]);
const handleChange = (val: string[]) => {};
</script>
<style lang="scss" scoped>
@import "../assets/scss/colors";

/* Hero Section  */

.__hero {
  display: flex;
  align-items: center;
  justify-content: space-around;
  max-width: 90%;
  margin: auto;
  padding-block: 7rem;
  padding-inline: 1rem;
  gap: 3rem;
  height: auto;
}
.hero__description {
  width: 50%;
}
.hero__description h3 {
  font-size: 4rem;
  font-family: "GraphikSemibold";
  font-weight: 900;
}
.hero__description .desc_span {
  color: rgba(0, 103, 252, 1);
  display: inline-block;
  transform: rotateY(180deg);
  margin-bottom: -14px;
}
.__hero p {
  font-family: "GraphikLight";
  padding-block: 2rem;
  line-height: 24px;
}
.hero__image {
  width: 40%;
}
.hero__image img {
  width: 100%;
}
.hero__buttons button {
  margin-inline: 8px;
}
.right-bg {
  position: absolute;
  top: 80%;
  left: 0%;
  z-index: -1;
}
.left-bg {
  position: absolute;
  top: 9%;
  right: 0%;
  z-index: -1;
}

/* Vedio Section  */

.video__section {
  position: relative;
  width: 100%;
  height: 100vh;
  overflow: hidden;
  margin: auto;
}

.video__section video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: -1;
  transform: translate(-50%, -50%);
}

.content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
  background-color: $primaryheader;
  font-family: "GraphikRegular";
  color: $text-color;
  text-align: center;
  padding: 14px;
  font-size: 1.2rem;
  border: 2px solid $white;
}
.content__data {
  background: rgba(255, 255, 255, 1);
  padding-block: 4rem;
  padding-inline: 2rem;
}
.content__data span {
  color: rgba(0, 103, 252, 1);
}

.content__data p {
  width: 70%;
  font-family: "GraphikRegular";
  color: $text-color;
  margin: auto;
  padding-block: 1.6rem;
}

/****
*
*
*
*
Works
*
*
*
***/

.works {
  width: 100%;
  height: auto;
  background-color: var(white);
  padding-block: 2rem;
}
.works h1 {
  margin-top: 2rem;
  padding-top: 2rem;
}
.works p {
  font-family: "GraphikLight";
  padding-block: 1rem;
}
.work__desc {
  text-align: center;
  font-size: 18px;
  margin-bottom: 4rem;
}

.works__box {
  display: flex;
  justify-content: center;
  margin-top: 5%;
  flex-wrap: wrap;
  width: 90%;
  margin: auto;
  gap: 1rem;
  padding-block: 2rem;
}

/* Default to 5 columns */
.box {
  flex-basis: 18%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 3rem 0.5rem;
  background-color: $white;
  box-shadow: 0px -19px 21px 0px rgba(0, 0, 0, 0.08);
  gap: 1rem;
  margin-bottom: 5%;
  box-sizing: border-box;
  position: relative;
  border-radius: 12px;
  min-width: 240px;
}

.box > div {
  width: 30%;
  margin-bottom: 1rem;
}

.box img {
  width: 100%;
}

.box p {
  text-align: center;
}

.box2 {
  flex-basis: 18%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 3rem 0.5rem;
  background: rgba(255, 255, 255, 1);
  box-shadow: 0px 30px 21px 0px rgba(0, 0, 0, 0.08);
  gap: 1rem;
  margin-bottom: 5%;
  box-sizing: border-box;
  position: relative;
  border-radius: 12px;
  min-width: 240px;
}

.box2 > div {
  width: 30%;
  margin-bottom: 1rem;
}

.box2 img {
  width: 100%;
}

.box2 p {
  text-align: center;
}

/* Reviews  */
.reviews__section {
  background: var(secondary);
}
.reviews {
  padding-inline: 2rem;
  max-width: 90%;
  margin: auto;
  padding-block: 3rem;
}
.reviews__desc {
  text-align: center;
  font-size: 18px;
  margin-bottom: 2rem;
}
.reviews__desc h1 {
  margin-top: 2rem;
  padding-top: 2rem;
}
.reviews__desc p {
  font-family: "GraphikLight";
  padding-block: 1rem;
}
.user__reviews {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 5%;
  gap: 10%;
  padding-block: 2rem;
}

.user__data {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 95%;
  gap: 2rem;
}
.user__details {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding-block: 2rem;
  border: 1px solid #eee;
  cursor: pointer;
  transition: 0.2s ease-in-out;
  gap: inherit;
}
.user__details.active,
.user__details:hover {
  background: rgba(255, 255, 255, 0.5);
  box-shadow: 1px 1px 13px 5px rgba(0, 0, 0, 0.1);
}
.user__details small {
  font-family: "GraphikLight";
  color: $text-color;
}
.user__data .user__image {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  transform: scale(1.5);
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}
.user__data .user__image img {
  width: 100%;
  height: auto;
  transform: scale(1.8);
}
.user__data .username {
  color: rgba(40, 138, 203, 1);
}

.user__comment h2 {
  color: rgba(40, 138, 203, 1);
}

.user__comment small {
  font-size: 16px;
  color: $text-color;
  font-family: "GraphikLight";
  margin-top: 2.5rem;
  display: block;
  line-height: 22px;
}
.faqs {
  padding-block: 3rem;
  padding-inline: 1rem;
  width: 80%;
  margin: auto;
}
.faqs h1 {
  text-align: center;
}
.faqs__accordin {
  padding-block: 2rem;
}
.faqs button {
  display: block;
  margin: auto;
}
.subscribe {
  width: 80%;
  margin: auto;
  padding-block: 2rem;
}
.subs_desc {
  display: flex;
  align-items: center;
  justify-content: space-around;
  padding-block: 1rem;
}
.subscribe form {
  width: 40%;
}
.subscribe .form__data {
  display: flex;
  padding: 0.5rem;
  align-items: center;
  justify-content: space-between;
  border: 1px solid rgba(43, 42, 76, 0.2);
  border-radius: 8px;
}
.subscribe form input {
  background-color: transparent;
  outline: none;
  border: none;
  width: 70%;
  font-family: "GraphikRegular";
  margin-left: 8px;
  font-size: 15px;
  font-weight: 400;
}
.subscribe-btn {
  padding: 10px 24px;
  border: 2px solid $text-color;
  border-radius: 4px;
  font-family: "GraphikRegular";
  font-size: 16px;
  cursor: pointer;
  color: $white;
  background-color: $text-color;
}
</style>
