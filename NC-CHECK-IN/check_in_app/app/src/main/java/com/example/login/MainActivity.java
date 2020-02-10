package com.example.login;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.media.AudioManager;
import android.media.Ringtone;
import android.media.RingtoneManager;
import android.media.ToneGenerator;
import android.net.Uri;
import android.os.Bundle;
import android.os.Vibrator;
import android.view.View;
import android.widget.Button;
import android.webkit.WebView;
import android.widget.TextView;
import android.widget.Toast;
import android.os.Handler;


import com.agik.AGIKSwipeButton.Controller.OnSwipeCompleteListener;
import com.agik.AGIKSwipeButton.View.Swipe_Button_View;
import com.example.login.Retrofit.APIUtils;
import com.example.login.Retrofit.DataClient;
import com.example.login.Retrofit.HTML;
import com.google.zxing.Result;
import com.karumi.dexter.Dexter;
import com.karumi.dexter.PermissionToken;
import com.karumi.dexter.listener.PermissionDeniedResponse;
import com.karumi.dexter.listener.PermissionGrantedResponse;
import com.karumi.dexter.listener.PermissionRequest;
import com.karumi.dexter.listener.single.PermissionListener;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import me.dm7.barcodescanner.zxing.ZXingScannerView;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity implements ZXingScannerView.ResultHandler {

    private ZXingScannerView scannerView;
    private DataClient dataClient= APIUtils.getData();
    private String TYPE, OLD_TYPE, PASSCODE, DELEGE_ID, LAST_TIME;
    private Swipe_Button_View swButton;
    private SharedPreferences sharedPreferences;
    private WebView webView;
    public MainActivity() {
    }

    @SuppressLint( "ResourceAsColor" )
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        initView();
        openCamare();

//        LAST_TIME = getTime();
//        try {
//            Thread.sleep(5000);
//        } catch (InterruptedException e) {
//            e.printStackTrace();
//        }
//        String t = getTime();
//
////        webView.loadData(t+ " ---"+ LAST_TIME, "text/html", "UTF-8");
////        Toast.makeText(this, subtractTime(getTime(), LAST_TIME)+"", Toast.LENGTH_SHORT).show();
//        webView.loadData(subtractTime(LAST_TIME, t)+"", "text/html", "UTF-8");
//


        swButton.setOnSwipeCompleteListener_forward_reverse(new OnSwipeCompleteListener() {
            @Override
            public void onSwipe_Forward(Swipe_Button_View swipeView) {
                swButton.setText("OUT");
                swButton.setThumbBackgroundColor(ContextCompat.getColor(MainActivity.this, R.color.bg_out));
                swButton.setSwipeBackgroundColor(ContextCompat.getColor(MainActivity.this, R.color.bg_out));
                TYPE = "OUT";
            }
            @Override
            public void onSwipe_Reverse(Swipe_Button_View swipeView) {
                swButton.setText("IN");
                swButton.setThumbBackgroundColor(ContextCompat.getColor(MainActivity.this, R.color.bg_in));
                swButton.setSwipeBackgroundColor(ContextCompat.getColor(MainActivity.this, R.color.bg_in));
                TYPE = "IN";
            }
        });

    }
    void initView(){
        webView = findViewById(R.id.webView);
        scannerView = findViewById(R.id.camera);
        swButton = findViewById(R.id.swButton);
        sharedPreferences = getSharedPreferences("PASSCODE", MODE_PRIVATE);
        PASSCODE = sharedPreferences.getString("PASSCODE", "");
        TYPE = "IN";
        OLD_TYPE = "OUT";

        //
        webView.setBackgroundColor(Color.TRANSPARENT);
        webView.setLayerType(WebView.LAYER_TYPE_SOFTWARE, null);
    }

    //Scan QR
    private void openCamare(){
        Dexter.withActivity(this)
                .withPermission(Manifest.permission.CAMERA)
                .withListener(new PermissionListener() {
                    @Override
                    public void onPermissionGranted(PermissionGrantedResponse response) {
                        scannerView.setResultHandler(MainActivity.this);
                        scannerView.startCamera();
                    }
                    @Override
                    public void onPermissionDenied(PermissionDeniedResponse response) {
                        Toast.makeText(MainActivity.this,"You must accpet",Toast.LENGTH_SHORT).show();
                    }
                    @Override
                    public void onPermissionRationaleShouldBeShown(PermissionRequest permission, PermissionToken token) {

                    }
                })
                .check();
    }

    @Override
    protected void onPause(){
//        scannerView.stopCamera();
        super.onPause();
    }
    @Override
    protected void onResume() {
        super.onResume();
        scannerView.startCamera();

    }
    @Override
    public void handleResult(Result rawResult) {
        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                scannerView.resumeCameraPreview(MainActivity.this);
            }
        }, 2000);

        processRawResult(rawResult.getText());
        //scannerView.resumeCameraPreview(this);
//        scannerView.stopCamera();

    }

    private void processRawResult(String text) {

        api_checkIn((text));
//        if(!text.equals(DELEGE_ID) )
//        {
//            DELEGE_ID = text;
//            OLD_TYPE = TYPE;
//            api_checkIn((text)); // request server
//            LAST_TIME = getTime();
//        }
//        else if(subtractTime(LAST_TIME, getTime())>10){
//            OLD_TYPE = TYPE;
//            api_checkIn((text)); // request server
////            Toast.makeText(this, "MO roi", Toast.LENGTH_SHORT).show();
//            LAST_TIME = getTime();
//        }
//        else if(!TYPE.equals(OLD_TYPE)){
//            OLD_TYPE = TYPE;
//            api_checkIn(text); // request server
//            LAST_TIME = getTime();
//        }

    }

    private String getID(String text){
        String [] arr =  text.split("|");
        return  arr[0];
    }
    private void api_checkIn(String ID){
        Call<HTML> callback = dataClient.checkIn(TYPE, ID, PASSCODE);
        callback.enqueue(new Callback<HTML>() {
            @Override
            public void onResponse(Call<HTML> call, Response<HTML> response) {
                HTML html = response.body();
                webView.loadData(html.getHtml(), "text/html", "UTF-8");

                if(html.getStatus().equals("success"))
                    animation_success();// sound beep and vibrate
                else
                    animation_fail();
//                scannerView.startCamera();
            }
            @Override
            public void onFailure(Call<HTML> call, Throwable t) {
                Toast.makeText(MainActivity.this, "Loi", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void animation_fail(){
        final ToneGenerator tg = new ToneGenerator(AudioManager.STREAM_NOTIFICATION, 100);
        tg.startTone(ToneGenerator.TONE_SUP_ERROR);

        Vibrator vibrator = (Vibrator) getSystemService(Context.VIBRATOR_SERVICE);
        if (vibrator.hasVibrator()) {
            vibrator.vibrate(800); // for 500 ms
        }
    }
    private void animation_success(){
        final ToneGenerator tg = new ToneGenerator(AudioManager.STREAM_NOTIFICATION, 100);
        tg.startTone(ToneGenerator.TONE_PROP_BEEP);

        Vibrator vibrator = (Vibrator) getSystemService(Context.VIBRATOR_SERVICE);
        if (vibrator.hasVibrator()) {
            vibrator.vibrate(300); // for 500 ms
        }
    }
    private String  getTime(){
        Calendar cal = Calendar.getInstance();
        SimpleDateFormat sdf = new SimpleDateFormat("YYYY-MM-dd HH:mm:ss");
        String time =  sdf.format(cal.getTime());
        return time;
    }
    private long subtractTime(String time1, String time2){
        SimpleDateFormat format = new SimpleDateFormat("YYYY-MM-dd HH:mm:ss");
        Date date1 = null;
        try {
            date1 = format.parse(time1);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        Date date2 = null;
        try {
            date2 = format.parse(time2);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        long difference = date2.getTime() - date1.getTime();
        return difference/1000;
    }
}
