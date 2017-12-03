package com.minorguys.tastyigniter;

import android.content.Intent;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.WindowManager;

import com.daimajia.androidanimations.library.Techniques;
import com.viksaa.sssplash.lib.activity.AwesomeSplash;
import com.viksaa.sssplash.lib.cnst.Flags;
import com.viksaa.sssplash.lib.model.ConfigSplash;

public class SplashScreen extends AwesomeSplash {

    @Override

    public void animationsFinished()
    {
        startActivity(new Intent(SplashScreen.this,MainActivity.class));

    }

    @Override
    public void initSplash(ConfigSplash configSplash)
    {
        ActionBar actionBar=getSupportActionBar();
        actionBar.hide();
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
        ///BACKGROUNG K LIYE
        configSplash.setBackgroundColor(R.color.bg_splash);
        configSplash.setAnimCircularRevealDuration(1000);
        configSplash.setRevealFlagX(Flags.REVEAL_LEFT);
        configSplash.setRevealFlagX(Flags.REVEAL_BOTTOM);

        //LOGO YAHAN AAYEGA

        configSplash.setLogoSplash(R.drawable.minorchef);

        configSplash.setAnimCircularRevealDuration(1000);
        configSplash.setAnimLogoSplashTechnique(Techniques.Bounce);

        ///TITLE YE HAIn
        configSplash.setTitleSplash("Food 24*7");
        configSplash.setTitleTextColor(R.color.white);
        configSplash.setTitleTextSize(26f);
        configSplash.setAnimTitleDuration(50);
        configSplash.setAnimTitleTechnique(Techniques.FlipInX);

    }

}
