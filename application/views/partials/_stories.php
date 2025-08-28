<style>
    
   
    
    .section-stories {
        width: 100%;
        display: block;
        position: relative;
        background: #ffffff;
    }

    .story-mode div {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        width: 115px;
    }

    .story-mode div img {
        border: 1px solid #e6e6e6;
        border-radius: 50%;
        box-sizing: border-box;
        display: block;
        width: 68px;
        height: 68px;
        margin: 0;
        transition: all ease 0.2s;
    }

    .story-mode div span {
        padding-top: 2px;
        text-transform: capitalize;
        text-align: center;
        font-weight: 500;
    }

    .story-mode div:hover img {
        border-color: #1a71eb;
    }

:root {
  --gutter: 20px;
}

.app {
  /*! padding: var(--gutter) 0; */
  display: grid;
  grid-gap: var(--gutter) 0;
  grid-template-columns: var(--gutter) 1fr var(--gutter);
  align-content: start;
}

.app > * {
  grid-column: 2 / -2;
}

.app > .full {
  grid-column: 1 / -1;
}

.hs {
  display: flex !important;
  /*! grid-gap: calc(var(--gutter) / 2); */
  grid-template-columns: 10px;
  grid-template-rows: minmax(150px, 1fr);
  grid-auto-flow: column;
  grid-auto-columns: calc(50% - var(--gutter) * 2);

  overflow-x: scroll;
  scroll-snap-type: x proximity;
  padding-bottom: calc(.75 * var(--gutter));
  margin-bottom: calc(-.25 * var(--gutter));
}

.hs:before,
.hs:after {
  content: '';
  width: 10px;
}

.hs > li,
.item {
  scroll-snap-align: center;
  padding: calc(var(--gutter) / 2 * 1.5);
  display: flex !important;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: #fff;
  border-radius: 8px;
  flex-direction: column;
  align-items: center;
  /*! width: 115px; */
}

.item img {
     border: 1px solid #e6e6e6;
        border-radius: 50%;
        box-sizing: border-box;
        display: block;
        width: 68px;
        height: 68px;
        margin: 0;
        transition: all ease 0.2s;
}

.item span {
     padding-top: 2px;
        text-transform: capitalize;
        text-align: center;
        font-weight: 500;
}

.item :hover img {
        border-color: #1a71eb;
}


.no-scrollbar {
  scrollbar-width: none;
  margin-bottom: 0;
  padding-bottom: 0;
}
.no-scrollbar::-webkit-scrollbar {
  display: none;
}


    }



</style>

<div class="<?php echo ($this->general_settings->slider_type == "boxed") ? "app container slider-story" : "container-fluid"; ?>">
    <div class="hs full no-scrollbar">
        <?php
        foreach ($stories as $stories) { ?>
		<div>
            <a href="<?php echo $stories->link ?>" class="item">
               
                    <img src="<?php echo base_url(); ?><?php echo $stories->image ?>" alt="">
                    <span><?php echo $stories->text; ?></span>
                
            </a></div>
        <?php } ?>

    </div>
</div>