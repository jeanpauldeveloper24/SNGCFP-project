import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Download extends StatefulWidget {
  const Download({super.key});

  @override
  State<Download> createState() => _DownloadState();
}

class _DownloadState extends State<Download> {
  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Archive des Documents Officiels",
          style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: const Color(0xFF1B4F72)),
        ),
        const SizedBox(height: 20),
        Expanded(
          child: GridView.count(
            crossAxisCount: 3,
            crossAxisSpacing: 15,
            mainAxisSpacing: 15,
            children: [
              _buildFileCard("Rapport Annuel 2025", "PDF", Colors.red),
              _buildFileCard("Tableau Budget 2026", "XLSX", Colors.green),
              _buildFileCard("Convention Cadre BAD", "PDF", Colors.red),
              _buildFileCard("Audit Externe S1", "PDF", Colors.red),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildFileCard(String name, String ext, Color color) {
    return Container(
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.black12),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.description, size: 40, color: color),
          const SizedBox(height: 10),
          Text(name, style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold), textAlign: TextAlign.center),
          const SizedBox(height: 5),
          Text(ext, style: TextStyle(color: color, fontSize: 10, fontWeight: FontWeight.bold)),
          const Spacer(),
          IconButton(onPressed: () {}, icon: const Icon(Icons.download_for_offline, color: Color(0xFF1B4F72))),
        ],
      ),
    );
  }
}