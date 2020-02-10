package com.example.login.Retrofit;




import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface DataClient {
    @GET("api/checkin/")
    Call<HTML> checkIn(@Query("TYPE") String TYPE, @Query("ID") String ID, @Query("PASSCODE") String PASSCODE);
    @GET("api/checkpasscode/")
    Call<String> checkPassCode(@Query("PASSCODE") String PASSCODE);

    @GET("android")
    Call<String> getJson();
    @GET("android/array")
    Call<ArrayList<String>> getArray();

    @GET("api/login")
    Call<String>  signin( @Query("mahv") String mahv, @Query("password") String password);
///real
    @FormUrlEncoded
    @POST("api/login")
    Call<String> login (@Field("mahv") String mahv, @Field("password") String password);

    @FormUrlEncoded
    @POST("api/reset")
    Call<String> reset(@Field("mahv") String mahv);

    @FormUrlEncoded
    @POST("api/setpassword")
    Call<String> setPassword(@Field("mahv") String mahv, @Field("password") String password, @Field("token") String token);

//    @GET("/api/diemdanh/{TOKEN}/{MAHV}")
//    Call <String> checkIn(@Path("TOKEN") String TOKEN, @Path("MAHV") String MAHV);








}
