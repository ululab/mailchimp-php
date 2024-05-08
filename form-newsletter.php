<div id="newsletter-float-banner" :class="{'banner-out': is_opened}">

      <div id="open-banner" :class="{'banner-out': is_opened}" @click="clickBanner()">
        <span>Iscriviti all Newsletter</span>
        <img src="<?php echo MEDIA_PATH . '/icona-freccia-white.svg' ?>'">
      </div>

      <h3>Resta aggiornato sulle novità e offerte</h3>

      <form id="newsletter-form" class="form">

        <div class="line">
          <div class="field">
            <div class="in-puddle">
              <input type="text" name="name_1" value="" v-model="field.name_1" required>
              <label for="name">Nome:</label>
            </div>

            <div v-if="errorMessage.name_1" class="field-error">
              <span>{{errorMessage.name_1}}</span>
            </div>
          </div>

          <div class="field">
            <div class="in-puddle">
              <input type="text" name="name_2" value="" v-model="field.name_2" required>
              <label for="name">Cognome:</label>
            </div>
            <div v-if="errorMessage.name_2" class="field-error">
              <span>{{errorMessage.name_2}}</span>
            </div>
          </div>
        </div>

        <div class="field w-100">
          <div class="in-puddle">
            <input type="text" name="email" value="" v-model="field.email" required>
            <label for="name">Email:</label>
          </div>
          <div v-if="errorMessage.email" class="field-error">
            <span>{{errorMessage.email}}</span>
          </div>
        </div>


        <p class="privacy">
          <input v-model="field.condition" type="checkbox" name="privacy" aria-required="true" class="error">
          <label for="privacy">Accetto di ricevere newsletter in accordo con il d.lgs.196/2003 e Reg. UE 2016/679</label>
          <div v-if="errorMessage.condition" class="field-error">
            <span>{{errorMessage.condition}}</span>
          </div>
        </p>

        <p class="submit">
          <button :disabled="isLoading" class="hover-anim" type="button" @click="preventSubmit()">Iscriviti</button>
          <span class="hover-anim" id="close-banner" @click="closeBanner()">Chiudi</span>
        </p>

      </form>

    </div>
