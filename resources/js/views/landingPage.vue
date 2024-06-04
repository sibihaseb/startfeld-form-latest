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
        <el-collapse v-model="activeNames" @change="handleChange" style="
    font-family: 'GraphikRegular';">
          <el-collapse-item title="Consistency" name="1">
            <div>
              Consistent with real life: in line with the process and logic of
              real life, and comply with languages and habits that the users are
              used to;
            </div>
            <div>
              Consistent within interface: all elements should be consistent,
              such as: design style, icons and texts, position of elements, etc.
            </div>
          </el-collapse-item>
          <el-collapse-item title="Feedback" name="2">
            <div>
              Operation feedback: enable the users to clearly perceive their
              operations by style updates and interactive effects;
            </div>
            <div>
              Visual feedback: reflect current state by updating or rearranging
              elements of the page.
            </div>
          </el-collapse-item>
          <el-collapse-item title="Efficiency" name="3">
            <div>
              Simplify the process: keep operating process simple and intuitive;
            </div>
            <div>
              Definite and clear: enunciate your intentions clearly so that the
              users can quickly understand and make decisions;
            </div>
            <div>
              Easy to identify: the interface should be straightforward, which
              helps the users to identify and frees them from memorizing and
              recalling.
            </div>
          </el-collapse-item>
          <el-collapse-item title="Controllability" name="4">
            <div>
              Decision making: giving advices about operations is acceptable,
              but do not make decisions for the users;
            </div>
            <div>
              Controlled consequences: users should be granted the freedom to
              operate, including canceling, aborting or terminating current
              operation.
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
const handleChange = (val: string[]) => {
  console.log(val);
};
</script>
