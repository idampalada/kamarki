@php(Theme::set('navStyle', 'light'))

<section class="relative table w-full py-32 lg:py-36">
    <div class="absolute inset-0 bg-black opacity-80"></div>
    <div class="container text-white">
        <h4 class="mb-5 text-3xl">You need to setup your homepage first!</h4>

        <p><strong>1. Go to Admin -> Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Admin -> Pages and create a page:</strong></p>

        <div class="my-5">
            <div class="my-2">- Content:</div>
            <div class="space-y-2">
                <div>[hero-banner style="1" title="We will help you find <br> your Wonderful home" title_highlight="Wonderful" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." background_images="backgrounds/01.jpg,backgrounds/02.jpg,backgrounds/03.jpg,backgrounds/04.jpg" enabled_search_box="1" enabled_search_projects="1"][/hero-banner]</div>
                <div>[intro-about-us title="Efficiency. Transparency. Control." description="Hously developed a platform for the Real Estate marketplace that allows buyers and sellers to easily execute a transaction on their own. The platform drives efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate Redefined." text_button_action="Learn More" url_button_action="#" image="general/about.jpg" youtube_video_url="https://www.youtube.com/watch?v=y9j-BL5ocW8"][/intro-about-us]</div>
                <div>[how-it-works title="How It Works" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." icon_1="mdi mdi-home-outline" title_1="Evaluate Property" description_1="If the distribution of letters and \'words\' is random, the reader will not be distracted from making." icon_2="mdi mdi-bag-personal-outline" title_2="Meeting with Agent" description_2="If the distribution of letters and \'words\' is random, the reader will not be distracted from making." icon_3="mdi mdi-key-outline" title_3="Close the Deal" description_3="If the distribution of letters and \'words\' is random, the reader will not be distracted from making."][/how-it-works]</div>
                <div>[properties-by-locations title="Find your inspiration with Hously" title_highlight_text="inspiration with" subtitle="Properties By Location and Country"][/properties-by-locations]</div>
                <div>[featured-projects title="Featured Projects" subtitle="We make the best choices with the hottest and most prestigious projects, please visit the details below to find out more." limit="6"][/featured-projects]</div>
                <div>[featured-properties title="Featured Properties" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/featured-properties]</div>
                <div>[recently-viewed-properties title="Recently Viewed Properties" subtitle="Your currently viewed properties." limit="3"][/recently-viewed-properties]</div>
                <div>[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/testimonials]</div>
                <div>[featured-agents title="Featured Agents" subtitle="Below is the featured agent." limit="6"][/featured-agents]</div>
                <div>[featured-posts title="Latest News" subtitle="Below is the latest real estate news we get regularly updated from reliable sources." limit="3"][/featured-posts]</div>
                <div>[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]</div>
            </div>
            <br>
            <div>- Template: <strong>Homepage</strong>.</div>
        </div>

        <p><strong>3. Then go to Admin -> Appearance -> Theme options -> Page to set your homepage.</strong></p>
    </div>
</section>
