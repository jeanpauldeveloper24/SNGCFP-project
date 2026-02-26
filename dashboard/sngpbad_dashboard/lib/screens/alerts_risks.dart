import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:sngpbad_dashboard/models/alerts_risks.dart';

// --- ECRAN PRINCIPAL ---
class AlertsRisks extends StatefulWidget {
  const AlertsRisks({super.key});

  @override
  State<AlertsRisks> createState() => _AlertsRisksState();
}

class _AlertsRisksState extends State<AlertsRisks> {
  List<RiskModel> allRisks = [];
  List<RiskModel> filteredRisks = [];
  bool isLoading = true;
  String searchQuery = "";
  String selectedLevel = "TOUS";

  @override
  void initState() {
    super.initState();
    _fetchRisks();
  }

  Future<void> _fetchRisks() async {
    setState(() => isLoading = true);
    try {
      final prefs = await SharedPreferences.getInstance();
      final response = await http.get(
        Uri.parse('http://127.0.0.1:8000/api/risks'),
        headers: {'Authorization': 'Bearer ${prefs.getString('auth_token')}'},
      );

      if (response.statusCode == 200) {
        List data = jsonDecode(response.body);
        setState(() {
          allRisks = data.map((item) => RiskModel(
            id: item['id'],
            title: item['title'],
            level: item['level'],
            label: item['label'],
            projectName: item['project']['nom'],
            updatedAt: DateTime.parse(item['updated_at']),
          )).toList();
          _filterData();
          isLoading = false;
        });
      }
    } catch (e) {
      setState(() => isLoading = false);
    }
  }

  Future<void> _archiveRisk(int id) async {
    final prefs = await SharedPreferences.getInstance();
    await http.put(
      Uri.parse('http://127.0.0.1:8000/api/risks/$id/archive'),
      headers: {'Authorization': 'Bearer ${prefs.getString('auth_token')}'},
    );
    _fetchRisks(); // Recharger la liste
  }

  void _filterData() {
    setState(() {
      filteredRisks = allRisks.where((r) {
        final matchesName = r.title.toLowerCase().contains(searchQuery.toLowerCase());
        final matchesLevel = selectedLevel == "TOUS" || r.level == selectedLevel;
        return matchesName && matchesLevel;
      }).toList();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildHeader(),
        _buildSearchBar(),
        _buildFilterChips(),
        const SizedBox(height: 15),
        Expanded(
          child: isLoading 
            ? const Center(child: CircularProgressIndicator()) 
            : _buildList(),
        ),
      ],
    );
  }

  Widget _buildHeader() {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Text("Suivi des Risques (${filteredRisks.length})", 
        style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold)),
    );
  }

  Widget _buildSearchBar() {
    return TextField(
      onChanged: (v) { searchQuery = v; _filterData(); },
      decoration: InputDecoration(
        hintText: "Rechercher...",
        prefixIcon: const Icon(Icons.search),
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(10), borderSide: BorderSide.none),
      ),
    );
  }

  Widget _buildFilterChips() {
    return Row(
      children: ["TOUS", "CRITIQUE", "MODERE", "MINEUR"].map((lvl) => Padding(
        padding: const EdgeInsets.only(right: 8),
        child: ChoiceChip(
          label: Text(lvl, style: const TextStyle(fontSize: 10)),
          selected: selectedLevel == lvl,
          onSelected: (s) { setState(() { selectedLevel = lvl; _filterData(); }); },
        ),
      )).toList(),
    );
  }

  Widget _buildList() {
    return ListView.builder(
      itemCount: filteredRisks.length,
      itemBuilder: (context, index) => _buildRiskCard(filteredRisks[index]),
    );
  }

  Widget _buildRiskCard(RiskModel risk) {
    return Card(
      elevation: 0,
      margin: const EdgeInsets.only(bottom: 8),
      child: ListTile(
        leading: Icon(Icons.warning, color: risk.color),
        title: Text(risk.title, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13)),
        subtitle: Text(risk.projectName, style: const TextStyle(fontSize: 11)),
        trailing: TextButton(
          onPressed: () => _showDetails(risk),
          child: const Text("Détails"),
        ),
      ),
    );
  }

  void _showDetails(RiskModel risk) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text(risk.title),
        content: Text("Projet: ${risk.projectName}\nImportance: ${risk.label}"),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text("Fermer")),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: Colors.green),
            onPressed: () {
              _archiveRisk(risk.id);
              Navigator.pop(context);
            },
            child: const Text("Marquer comme résolu", style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }
}