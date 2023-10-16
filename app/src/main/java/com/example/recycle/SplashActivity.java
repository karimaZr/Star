package com.example.recycle;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;

public class SplashActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);
        ImageView logo = findViewById(R.id.logo);
        logo.animate().rotation(360f).setDuration(2000);//rotation
        logo.animate().scaleX(0.5f).scaleY(0.5f).setDuration(3000);//retour en ariere en minimisant les dim

        //logo.animate().translationYBy(1000f).setDuration(2000); //translater en bas
        //logo.animate().alpha(0f).setDuration(6000);//dimuner la luminosité de photo jusqu'a diparition
        Thread t1 = new Thread(){
            @Override
            public void run() {
                try {
                    sleep(5000);
                    Intent intent = new Intent(SplashActivity.this, ListActivity.class);
                    startActivity(intent);
                    SplashActivity.this.finish();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
            }
        };
        t1.start();



    }
}