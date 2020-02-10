package com.example.login;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.Editable;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import com.example.login.Retrofit.APIUtils;
import com.example.login.Retrofit.DataClient;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class init extends AppCompatActivity {

    EditText edPassCode;
    ImageButton ibGo;
    DataClient dataClient= APIUtils.getData();
    SharedPreferences sharedPreferences;
    private String PASSCODE;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_init);
        initView();
        ibGo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                PASSCODE = edPassCode.getText().toString();
                api_checkPassCode(PASSCODE);

            }
        });
    }
    private void initView(){
        edPassCode = findViewById(R.id.edPassCode);
        ibGo = findViewById(R.id.ibGo);
        sharedPreferences = getSharedPreferences("PASSCODE", MODE_PRIVATE);

    }
    private void api_checkPassCode(final String passCode){
        Call<String> callback = dataClient.checkPassCode(passCode);
        callback.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                String message = response.body();
                if(message.equals("1")) {
                    sharedPreferences.edit().putString("PASSCODE", PASSCODE).apply();
                    Intent intent = new Intent(init.this, MainActivity.class);
                    startActivity(intent);
                }
                else {
                    edPassCode.setText("");
                    edPassCode.setHint(R.string.invalid);
                    edPassCode.setHintTextColor(getResources().getColor(R.color.bg_out));
                }

            }
            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Toast.makeText(init.this, "ERROR", Toast.LENGTH_SHORT).show();
            }
        });
    }
}
