import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:sngpbad_dashboard/models/project_model.dart';


class ProjectService {
  static const String baseUrl = "http://127.0.0.1:8000/api";

  Future<List<ProjectModel>> fetchProjects() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final String? token = prefs.getString('auth_token');

      final response = await http.get(
        Uri.parse('$baseUrl/projets'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token', // C'est ici que la magie opère
        },
      );

      if (response.statusCode == 200) {
        List jsonResponse = jsonDecode(response.body);
        return jsonResponse.map((data) => ProjectModel.fromJson(data)).toList();
      } else {
        throw Exception("Erreur lors de la récupération des projets");
      }
    } catch (e) {
      print("Erreur ProjectService: $e");
      return [];
    }
  }
}