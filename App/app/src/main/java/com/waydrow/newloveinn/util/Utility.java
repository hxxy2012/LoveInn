package com.waydrow.newloveinn.util;

import com.google.gson.Gson;
import com.waydrow.newloveinn.bean.ActivityAll;
import com.waydrow.newloveinn.bean.ActivitySummary;
import com.waydrow.newloveinn.bean.Volunteer;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Waydrow on 2017/3/4.
 */

public class Utility {

    // 解析志愿者信息
    public static Volunteer handleVolunInfo(String response) {
        return new Gson().fromJson(response, Volunteer.class);
    }

    // 解析活动列表
    public static List<ActivitySummary> handleActivityList(String response) {
        List<ActivitySummary> list = new ArrayList<>();
        try {
            JSONArray jsonArray = new JSONArray(response);
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject object = jsonArray.getJSONObject(i);
                String time = object.getString("begintime");
                time = time.split(" ")[0];
                object.put("begintime", time);
                list.add(new Gson().fromJson(object.toString(), ActivitySummary.class));
            }
            return list;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    // 解析活动详情
    public static ActivityAll handleActivityInfo(String response) {
        try {
            return new Gson().fromJson(response, ActivityAll.class);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }
}
